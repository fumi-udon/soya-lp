<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')->schema([
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required(),

                    TextInput::make('name')
                        ->required()
                        ->label('Product Name (Public)')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->required()
                        ->unique(Product::class, 'slug', ignoreRecord: true)
                        ->helperText('URLに使用されます（自動生成されます）'),

                    TextInput::make('staff_name')
                        ->label('Staff Name (Kitchen)'),

                    TextInput::make('price')
                        ->numeric()
                        ->suffix('DT'),

                    Select::make('order_type')
                        ->options(['kitchen' => 'Kitchen', 'counter' => 'Counter'])
                        ->default('kitchen'),

                    Toggle::make('is_active')
                        ->label('Available')
                        ->default(true),
                ])->columns(2),

                Section::make('Presentation')->schema([
                    FileUpload::make('image')
                        ->image()
                        ->directory('products'),
                    RichEditor::make('description')
                        ->columnSpanFull(),
                    TextInput::make('ingredients')
                        ->label('Ingredients (for AI recommendations)'),
                ])->collapsed(),

                Section::make('Options & Toppings')
                    ->description('Add variations like noodle types or extra toppings.')
                    ->schema([
                        Repeater::make('productVariants')
                            ->relationship()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->placeholder('e.g. Extra Egg'),
                                TextInput::make('staff_name')
                                    ->label('Kitchen Code'),
                                TextInput::make('price_adjustment')
                                    ->numeric()
                                    ->default(0)
                                    ->label('+ Price (DT)'),
                                Toggle::make('is_required')
                                    ->label('Selection Required?')
                            ])->columns(4)
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('category.name')->sortable(),
                Tables\Columns\TextColumn::make('price')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
