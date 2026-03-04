<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = '注文管理';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Placeholder::make('receipt_view')
                ->hiddenLabel()
                ->content(function ($record) {
                    if (!$record) return '';

                    // 1. 超コンパクトな顧客情報 & 備考（あれば赤色で強調）
                    $html = '<div class="mb-3">';
                    $html .= '<div class="text-[11px] text-gray-500 flex items-center gap-1.5 font-medium"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> ' . e($record->customer_name) . ' <span class="mx-1 text-gray-300">|</span> 📞 ' . e($record->customer_phone) . '</div>';
                    if (!empty($record->notes)) {
                        $html .= '<div class="mt-1.5 p-2 bg-red-50 border border-red-100 rounded text-[12px] text-red-600 font-bold">⚠️ 備考: ' . nl2br(e($record->notes)) . '</div>';
                    }
                    $html .= '</div>';

                    // 2. スマホ特化レシート
                    $html .= '<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">';
                    if ($record->items->isEmpty()) {
                        $html .= '<div class="p-4 text-sm text-gray-400">明細がありません</div>';
                    } else {
                        $html .= '<div class="divide-y divide-gray-100">';
                        foreach ($record->items as $item) {
                            $optionsHtml = '';
                            if (!empty($item->variants)) {
                                $opts = [];
                                foreach ($item->variants as $v) {
                                    $p = !empty($v['price_adjustment']) ? "(+{$v['price_adjustment']})" : '';
                                    $opts[] = "{$v['name']} {$p}";
                                }
                                $optionsHtml = '<div class="text-[12px] text-gray-500 mt-1 mb-0.5 leading-tight">' . implode(' / ', $opts) . '</div>';
                            }

                            $price = number_format($item->price, 3);
                            $subtotal = number_format($item->price * $item->quantity, 3);

                            $html .= '<div class="p-3 flex justify-between items-start gap-3">';
                            $html .= '<div class="flex-1 min-w-0">';
                            $html .= "<div class='font-bold text-[15px] text-gray-900 leading-tight'>{$item->product_name}</div>";
                            $html .= $optionsHtml;
                            $html .= "<div class='text-[12px] text-gray-400 mt-1 font-mono'>{$price} DT × {$item->quantity}</div>";
                            $html .= '</div>';
                            $html .= "<div class='font-bold text-[15px] text-gray-900 whitespace-nowrap pt-0.5'>{$subtotal}</div>";
                            $html .= '</div>';
                        }
                        $html .= '</div>';

                        // 合計金額フッター
                        $total = number_format($record->total_price, 3);
                        $html .= '<div class="p-3 bg-gray-50 border-t border-gray-200 flex justify-between items-center">';
                        $html .= '<span class="font-bold text-[13px] tracking-widest text-gray-500 uppercase">Total</span>';
                        $html .= '<span class="font-bold text-lg text-[#e60012] font-mono">' . $total . ' DT</span>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';

                    // 3. 注文番号と日時の極小表示（最下部）
                    $date = $record->created_at ? $record->created_at->format('Y/m/d H:i') : '';
                    $html .= '<div class="mt-3 text-[10px] text-gray-400 flex justify-between px-1">';
                    $html .= '<span>Order #' . e($record->order_number) . '</span>';
                    $html .= '<span>' . $date . '</span>';
                    $html .= '</div>';

                    return new HtmlString($html);
                })->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('created_at', 'desc')->columns([
            Tables\Columns\TextColumn::make('created_at')->label('日時')->dateTime('M d, H:i')->sortable(),
            Tables\Columns\TextColumn::make('order_number')->label('注文番号')->searchable()->weight('bold'),
            Tables\Columns\TextColumn::make('customer_name')->label('顧客名')->searchable(),
            Tables\Columns\TextColumn::make('total_price')->label('売上')->numeric(3)->suffix(' DT'),
        ])->filters([
            Tables\Filters\TernaryFilter::make('is_test')->label('テスト(削除済)の表示')->default(0),
        ])->actions([
            Tables\Actions\EditAction::make()->label('詳細確認'),

            Tables\Actions\Action::make('delete_order')
                ->label('削除')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('注文の削除')
                ->modalDescription('担当者パスコードを入力して削除してください。')
                ->form([
                    Forms\Components\TextInput::make('passcode')
                        ->label('パスコード')
                        ->password()
                        ->required()
                        ->rule('in:2017')
                        ->validationMessages(['in' => 'パスコードが正しくありません。']),
                ])
                ->action(function (Order $record) {
                    $record->update(['is_test' => true]);
                }),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
