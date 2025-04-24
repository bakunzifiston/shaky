<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('customer_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('customer_Phone')
                    ->maxLength(255)
                    ->default(null),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                    Forms\Components\TextInput::make('quantity_sold')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $sellingPrice = $get('selling_price');
                        if (is_numeric($sellingPrice) && is_numeric($state)) {
                            $set('total_revenue', $sellingPrice * $state);
                        }
                    }),
                
                Forms\Components\TextInput::make('selling_price')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $quantitySold = $get('quantity_sold');
                        if (is_numeric($quantitySold) && is_numeric($state)) {
                            $set('total_revenue', $quantitySold * $state);
                        }
                    }),
                
                Forms\Components\TextInput::make('total_revenue')
                ->numeric()
                ->readOnly()
                ->required(),
                
                Select::make('payment_status')
                    ->required()
                    ->options([
                        'Paid' => 'Paid',
                        'Pending' => 'Pending',
                        'Credit' => 'Credit',
                    ])
                    ->label('Payment Status'),
                
                Select::make('delivery_status')
                    ->required()
                    ->options([
                        'Delivered' => 'Delivered',
                        'Pending' => 'Pending',
                        'In Transit' => 'In Transit',
                    ])
                    ->label('Delivery Status'),
                
                    Forms\Components\Select::make('sales_channel')
                    ->label('Sales Channel')
                    ->required()
                    ->options([
                        'Momo Pay' => 'Momo Pay',
                        'Card' => 'Card',
                        'Cash' => 'Cash',
                    ])
                    ->searchable(),
                Forms\Components\TextInput::make('invoice_number')

                    ->maxLength(255),
                Forms\Components\DatePicker::make('sale_date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sales_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_sold')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('selling_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_revenue')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status'),
                Tables\Columns\TextColumn::make('delivery_status'),
                Tables\Columns\TextColumn::make('sales_channel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sale_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
