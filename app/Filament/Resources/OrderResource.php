<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Shop Management';
    protected static ?int $navigationSort = 1; // メニューの一番上に表示

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')->schema([
                    Forms\Components\TextInput::make('order_number')->disabled(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending (確認待ち)',
                            'confirmed' => 'Confirmed (確定)',
                            'completed' => 'Completed (完了)',
                            'cancelled' => 'Cancelled (キャンセル)',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('total_price')->disabled()->suffix('DT'),
                    Forms\Components\TextInput::make('order_type')->disabled(),
                ])->columns(2),

                Forms\Components\Section::make('Customer Details')->schema([
                    Forms\Components\TextInput::make('customer_name')->disabled(),
                    Forms\Components\TextInput::make('customer_phone')->disabled(),
                    Forms\Components\Textarea::make('notes')->disabled()->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Section::make('Order Items')->schema([
                    Forms\Components\Repeater::make('items')
                        ->relationship('items')
                        ->schema([
                            Forms\Components\TextInput::make('product_name')->disabled(),
                            Forms\Components\TextInput::make('price')->disabled()->suffix('DT'),
                            Forms\Components\TextInput::make('quantity')->disabled(),
                            // トッピング（JSON）を文字列化して表示
                            Forms\Components\Placeholder::make('variants_display')
                                ->label('Selected Options')
                                ->content(function ($record) {
                                    if (!$record || empty($record->variants)) return 'None';
                                    return collect($record->variants)->pluck('name')->join(', ');
                                })->columnSpanFull(),
                        ])
                        ->columns(3)
                        ->disableItemCreation()
                        ->disableItemDeletion()
                        ->disableItemMovement(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc') // 最新を一番上に
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // ★一覧画面から直接ステータスを変更可能
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->searchable()
                    ->icon('heroicon-o-phone'),
                Tables\Columns\TextColumn::make('order_type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Takeaway' => 'warning',
                        'Dine-in' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->suffix(' DT')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, H:i')
                    ->sortable(),
            ])
            ->filters([
                // 必要に応じてステータス絞り込みなどを追加可能
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('View / Edit'),
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
