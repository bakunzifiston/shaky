<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryRecordResource\Pages;
use App\Models\InventoryRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InventoryRecordResource extends Resource
{
    protected static ?string $model = InventoryRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Supplier & Item Details')
                    ->schema([
                        Forms\Components\TextInput::make('supplier_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Invoice Number')
                            ->maxLength(255),
                        Forms\Components\Select::make('item_type')
                            ->required()
                            ->options([
                                'Product' => 'Product',
                                'Raw Material' => 'Raw Material',
                            ])
                            ->live(),
                        Forms\Components\TextInput::make('item_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('product_id')
                            ->label('Link to Product')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->visible(fn (Forms\Get $get) => $get('item_type') === 'Product'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Quantities & Cost')
                    ->schema([
                        Forms\Components\TextInput::make('quantity_in')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::suggestUnitCost($set, $get)),
                        Forms\Components\TextInput::make('quantity_out')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('unit_cost')
                            ->label('Unit Cost (RWF)')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Cost per unit for FIFO valuation')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::suggestUnitCost($set, $get)),
                        Forms\Components\TextInput::make('damaged')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('storage_location')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('record_date')
                            ->required()
                            ->default(now()),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Supplier Payment')
                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Amount (RWF)')
                            ->numeric()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                self::updatePaymentStatus($set, $get);
                                self::suggestUnitCost($set, $get);
                            }),
                        Forms\Components\TextInput::make('amount_paid')
                            ->label('Amount Paid (RWF)')
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                self::updatePaymentStatus($set, $get);
                            }),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'Paid' => 'Paid',
                                'Partial' => 'Partially Paid',
                                'Unpaid' => 'Unpaid',
                            ])
                            ->default('Unpaid')
                            ->required(),
                        Forms\Components\DatePicker::make('payment_due_date')
                            ->label('Payment Due Date'),
                        Forms\Components\Placeholder::make('remaining_balance')
                            ->label('Remaining Balance')
                            ->content(function (Forms\Get $get) {
                                $total = (float) ($get('total_amount') ?? 0);
                                $paid = (float) ($get('amount_paid') ?? 0);
                                return number_format($total - $paid, 0) . ' RWF';
                            }),
                    ])
                    ->columns(3),
            ]);
    }

    protected static function updatePaymentStatus(Forms\Set $set, Forms\Get $get): void
    {
        $total = (float) ($get('total_amount') ?? 0);
        $paid = (float) ($get('amount_paid') ?? 0);

        if ($total <= 0) {
            $set('payment_status', 'Unpaid');
        } elseif ($paid >= $total) {
            $set('payment_status', 'Paid');
        } elseif ($paid > 0) {
            $set('payment_status', 'Partial');
        } else {
            $set('payment_status', 'Unpaid');
        }
    }

    protected static function suggestUnitCost(Forms\Set $set, Forms\Get $get): void
    {
        $total = (float) ($get('total_amount') ?? 0);
        $qty = (float) ($get('quantity_in') ?? 0);
        if ($qty > 0 && $total > 0) {
            $set('unit_cost', round($total / $qty, 2));
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('item_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Product' => 'success',
                        'Raw Material' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('item_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity_in')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state . ' L'),
                Tables\Columns\TextColumn::make('quantity_out')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state . ' L'),
                Tables\Columns\TextColumn::make('unit_cost')
                    ->label('Unit Cost')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0) . ' RWF' : '-'),
                Tables\Columns\TextColumn::make('line_value')
                    ->label('Line Value')
                    ->formatStateUsing(fn ($record) => number_format($record->line_value, 0) . ' RWF'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0) . ' RWF' : '-'),
                Tables\Columns\TextColumn::make('amount_paid')
                    ->label('Paid')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => number_format($state ?? 0, 0) . ' RWF'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Paid' => 'success',
                        'Partial' => 'warning',
                        'Unpaid' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_overdue')
                    ->label('Overdue')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->getStateUsing(fn ($record) => $record->is_overdue),
                Tables\Columns\TextColumn::make('record_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('storage_location')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('damaged')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'Paid' => 'Paid',
                        'Partial' => 'Partially Paid',
                        'Unpaid' => 'Unpaid',
                    ]),
                Tables\Filters\SelectFilter::make('item_type')
                    ->options([
                        'Product' => 'Product',
                        'Raw Material' => 'Raw Material',
                    ]),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventoryRecords::route('/'),
            'create' => Pages\CreateInventoryRecord::route('/create'),
            'view' => Pages\ViewInventoryRecord::route('/{record}'),
            'edit' => Pages\EditInventoryRecord::route('/{record}/edit'),
        ];
    }
}
