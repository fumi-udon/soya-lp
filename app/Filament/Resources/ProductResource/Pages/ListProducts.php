<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Filament\Actions;
use Filament\Facades\Filament; // ★ 追加：現在の店舗を取得するため
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            // CSVインポート
            Actions\Action::make('importCsv')
                ->label('Import CSV (Fix Paths)')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    FileUpload::make('csv_file')
                        ->label('Upload CSV File')
                        ->disk('local')
                        ->directory('csv-imports')
                        ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    set_time_limit(300);
                    $file = storage_path('app/' . $data['csv_file']);
                    $this->importProducts($file);
                    Notification::make()->title('Import & Path Fix Completed!')->success()->send();
                }),

            // 現在の店舗の商品を全削除（他店舗には影響しないように修正）
            Actions\Action::make('deleteAll')
                ->label('Delete ALL')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('⚠️ DANGER ZONE')
                ->modalDescription('Type "delete" to confirm.')
                ->form([
                    TextInput::make('confirmation')
                        ->label('Confirmation')
                        ->placeholder('delete')
                        ->required()
                        ->rules(['required', 'in:delete']),
                ])
                ->action(function () {
                    $tenantId = Filament::getTenant()->id; // ★ 現在の店舗ID

                    DB::transaction(function () use ($tenantId) {
                        ProductVariant::where('tenant_id', $tenantId)->delete();
                        Product::where('tenant_id', $tenantId)->delete();
                    });
                    Notification::make()->title('Deleted all products for this store.')->danger()->send();
                }),
        ];
    }

    protected function importProducts(string $filePath)
    {
        $handle = fopen($filePath, 'r');
        if ($handle === false) return;

        fgetcsv($handle); // ヘッダー・スキップ

        $targetDir = 'products';
        $tenantId = Filament::getTenant()->id; // ★ 現在選択している店舗IDを取得

        DB::transaction(function () use ($handle, $targetDir, $tenantId) {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($row[0])) continue;

                $name = $row[0];
                $price = is_numeric($row[1]) ? $row[1] : 0;
                $categorySlug = $row[2];
                $description = $row[3] ?? '';
                $imageName = $row[4] ?? null;
                $variantsString = $row[5] ?? '';

                if ($imageName && !Str::startsWith($imageName, 'products/')) {
                    $imageName = 'products/' . $imageName;
                }

                // ★ カテゴリ登録（現在の店舗IDを紐付け）
                $category = Category::firstOrCreate(
                    ['slug' => Str::slug($categorySlug), 'tenant_id' => $tenantId],
                    ['name' => ucfirst(str_replace('-', ' ', $categorySlug)), 'is_active' => true]
                );

                // ★ 商品検索（現在の店舗IDで絞り込み）
                $product = Product::where('name', $name)->where('tenant_id', $tenantId)->first();

                $productData = [
                    'tenant_id' => $tenantId, // ★ 商品にも店舗IDを紐付け
                    'category_id' => $category->id,
                    'price' => $price,
                    'description' => $description,
                    'image' => $imageName,
                ];

                if ($product) {
                    $product->update($productData);
                    $product->productVariants()->delete(); // 一旦バリアントを削除して再登録
                } else {
                    $productData['name'] = $name;
                    $productData['slug'] = Str::slug($name);
                    $productData['is_active'] = true;
                    $productData['order_type'] = 'kitchen';
                    $product = Product::create($productData);
                }

                // ★ バリアント登録（店舗IDを紐付け）
                if (!empty($variantsString)) {
                    $variantItems = explode(',', $variantsString);
                    foreach ($variantItems as $item) {
                        $parts = explode(':', trim($item));
                        if (count($parts) < 2) continue;
                        $product->productVariants()->create([
                            'tenant_id' => $tenantId, // ★ トッピング等にも店舗IDを紐付け
                            'name' => trim($parts[0]),
                            'price_adjustment' => is_numeric($parts[1]) ? $parts[1] : 0,
                            'is_required' => isset($parts[2]) ? (bool)$parts[2] : false,
                        ]);
                    }
                }
            }
        });

        fclose($handle);
    }
}
