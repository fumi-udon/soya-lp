<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

            // 全削除
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
                    DB::transaction(function () {
                        ProductVariant::query()->delete();
                        Product::query()->delete();
                    });
                    Notification::make()->title('Deleted all products.')->danger()->send();
                }),
        ];
    }

    protected function importProducts(string $filePath)
    {
        $handle = fopen($filePath, 'r');
        if ($handle === false) return;

        fgetcsv($handle); // ヘッダー・スキップ

        // 画像処理（最適化機能は一旦おいておき、まずはパス修復を優先します）
        $targetDir = 'products';

        DB::transaction(function () use ($handle, $targetDir) {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($row[0])) continue;

                $name = $row[0];
                $price = is_numeric($row[1]) ? $row[1] : 0;
                $categorySlug = $row[2];
                $description = $row[3] ?? '';
                $imageName = $row[4] ?? null;
                $variantsString = $row[5] ?? '';

                // ★ここが修正ポイント：パスの自動補正
                // 画像名があって、まだ 'products/' が付いていないなら付ける
                if ($imageName && !Str::startsWith($imageName, 'products/')) {
                    $imageName = 'products/' . $imageName;
                }

                // カテゴリ登録
                $category = Category::firstOrCreate(
                    ['slug' => Str::slug($categorySlug)],
                    ['name' => ucfirst(str_replace('-', ' ', $categorySlug)), 'is_active' => true]
                );

                // 商品検索
                $product = Product::where('name', $name)->first();

                $productData = [
                    'category_id' => $category->id,
                    'price' => $price,
                    'description' => $description,
                    'image' => $imageName, // 補正済みのパスを入れる
                ];

                if ($product) {
                    $product->update($productData);
                    // バリアント再登録のため削除
                    $product->productVariants()->delete();
                } else {
                    $productData['name'] = $name;
                    $productData['slug'] = Str::slug($name);
                    $productData['is_active'] = true;
                    $productData['order_type'] = 'kitchen';
                    $product = Product::create($productData);
                }

                // バリアント登録
                if (!empty($variantsString)) {
                    $variantItems = explode(',', $variantsString);
                    foreach ($variantItems as $item) {
                        $parts = explode(':', trim($item));
                        if (count($parts) < 2) continue;
                        $product->productVariants()->create([
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
