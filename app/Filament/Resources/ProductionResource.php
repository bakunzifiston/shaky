<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionResource\Pages;
use App\Models\Production;
use App\Models\InventoryRecord;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('batch_id')
                    ->required()
                    ->maxLength(255),

                Select::make('product_id')
                    ->relationship('product', 'type')
                    ->required(),

Repeater::make('inventory_record_id')
    ->label('Raw Materials Used')
    ->schema([
        Select::make('inventory_id')
            ->label('Select Raw Material')
            ->options(\App\Models\InventoryRecord::pluck('item_name', 'id'))
            ->searchable()
            ->required(),

        TextInput::make('quantity_used')
            ->numeric()
            ->label('Quantity Used')
            ->required(),
    ])
    ->columns(2)
    ->defaultItems(1)
    ->createItemButtonLabel('Add Material')
    ->required(),

                Forms\Components\TextInput::make('quantity_produced')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('damaged')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Forms\Components\DatePicker::make('production_date')
                    ->required(),

                Forms\Components\TextInput::make('responsible_staff')
                    ->maxLength(255)
                    ->default(null),

                Select::make('barcode')
                    ->label('Select Barcode')
                    ->options([
                        '6784293819719' => '6784293819719',
                        '5781429281069' => '5781429281069',
                        '5675098214278' => '5675098214278',
                        '3078055640615' => '3078055640615',
                    ])
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Textarea::make('quality_control_notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('batch_id')->searchable(),
                Tables\Columns\TextColumn::make('product.type')->searchable(),
                Tables\Columns\TextColumn::make('inventory_record_id')
    ->label('Raw Materials')
    ->formatStateUsing(function ($state) {
        if (is_string($state)) {
            $state = json_decode($state, true);
        }

        if (!is_array($state)) {
            return '-';
        }

        // Build "Material (Qty)" list
        return collect($state)->map(function ($item) {
            $name = \App\Models\InventoryRecord::find($item['inventory_id'])->item_name ?? 'Unknown';
            $qty = $item['quantity_used'] ?? 0;
            return "{$name} ({$qty})";
        })->join(', ');
    }),

Tables\Columns\TextColumn::make('inventory_record_id')
    ->label('Raw Materials & Qty Used')
    ->formatStateUsing(function ($record) {
        $materials = $record->inventory_record_id;

        // Ensure it’s an array
        if (!is_array($materials)) {
            $materials = json_decode($materials, true) ?? [];
        }

        // Nothing found
        if (empty($materials)) {
            return '—';
        }

        // Build list like: Maize - 10, Wheat - 5
        return collect($materials)->map(function ($item) {
            $inventory = \App\Models\InventoryRecord::find($item['inventory_id'] ?? null);
            $name = $inventory?->item_name ?? 'Unknown';
            $qty = $item['quantity_used'] ?? 0;
            return "{$name}: {$qty}";
        })->join(', ');
    })
    ->wrap(),
                Tables\Columns\TextColumn::make('quantity_produced')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state . ' bottles'),
                Tables\Columns\TextColumn::make('damaged')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('production_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('responsible_staff')->searchable(),
                Tables\Columns\TextColumn::make('barcode')->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProductions::route('/'),
            'create' => Pages\CreateProduction::route('/create'),
            'view' => Pages\ViewProduction::route('/{record}'),
            'edit' => Pages\EditProduction::route('/{record}/edit'),
        ];
    }
}
