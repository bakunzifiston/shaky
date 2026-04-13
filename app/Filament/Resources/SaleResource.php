<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer & Invoice')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('customer_Phone')
                            ->label('Customer Phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('invoice_number')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('sale_date')
                            ->required()
                            ->default(now()),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Products')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'type')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn (Forms\Set $set) => $set('production_id', null)),
                                Select::make('production_id')
                                    ->label('Batch')
                                    ->required()
                                    ->options(function (Forms\Get $get) {
                                        $productId = $get('product_id');
                                        if (!$productId) return [];
                                        return \App\Models\Production::where('product_id', $productId)
                                            ->where('quantity_produced', '>', 0)
                                            ->pluck('batch_id', 'id')
                                            ->toArray();
                                    })
                                    ->searchable(),
                                Forms\Components\TextInput::make('quantity_sold')
                                    ->label('Qty')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0.01)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                        $qty = (float) ($get('quantity_sold') ?? 0);
                                        $price = (float) ($get('unit_price') ?? 0);
                                        $set('line_total', round($qty * $price, 2));
                                    }),
                                Forms\Components\TextInput::make('unit_price')
                                    ->label('Price')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                        $qty = (float) ($get('quantity_sold') ?? 0);
                                        $price = (float) ($get('unit_price') ?? 0);
                                        $set('line_total', round($qty * $price, 2));
                                    }),
                                Forms\Components\TextInput::make('line_total')
                                    ->label('Total')
                                    ->numeric()
                                    ->readOnly()
                                    ->dehydrated(),
                            ])
                            ->columns(5)
                            ->defaultItems(1)
                            ->createItemButtonLabel('Add Product')
                            ->reorderable()
                            ->collapsible(),
                    ]),

                Forms\Components\Section::make('Payment & Delivery')
                    ->schema([
                        Forms\Components\Placeholder::make('total_display')
                            ->label('Invoice Total')
                            ->content(function (Forms\Get $get) {
                                $items = $get('items') ?? [];
                                $total = 0;
                                foreach ($items as $item) {
                                    $total += ((float) ($item['quantity_sold'] ?? 0)) * ((float) ($item['unit_price'] ?? 0));
                                }
                                return number_format($total, 0) . ' RWF';
                            }),
                        Forms\Components\Hidden::make('total_revenue')->dehydrated()->default(0),
                        Select::make('payment_status')
                            ->required()
                            ->options([
                                'Paid' => 'Paid',
                                'Pending' => 'Pending',
                                'Credit' => 'Credit',
                            ]),
                        Select::make('delivery_status')
                            ->required()
                            ->options([
                                'Delivered' => 'Delivered',
                                'Pending' => 'Pending',
                                'In Transit' => 'In Transit',
                            ]),
                        Select::make('sales_channel')
                            ->required()
                            ->options([
                                'Momo Pay' => 'Momo Pay',
                                'Card' => 'Card',
                                'Cash' => 'Cash',
                            ]),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('sales_id')
                    ->label('Sale ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Items')
                    ->counts('items'),
                Tables\Columns\TextColumn::make('total_revenue')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state ?? 0, 0) . ' RWF'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Paid' => 'success',
                        'Pending', 'Credit' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('delivery_status')->badge(),
                Tables\Columns\TextColumn::make('sale_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'view' => Pages\ViewSale::route('/{record}'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
