<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewSale extends ViewRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Invoice')
                    ->schema([
                        TextEntry::make('sales_id')->label('Sale ID'),
                        TextEntry::make('customer_name'),
                        TextEntry::make('invoice_number'),
                        TextEntry::make('sale_date')->date(),
                        TextEntry::make('payment_status')->badge(),
                        TextEntry::make('delivery_status')->badge(),
                        TextEntry::make('total_revenue')->formatStateUsing(fn ($state) => number_format($state ?? 0) . ' RWF'),
                    ])
                    ->columns(2),
                Section::make('Items')
                    ->schema([
                        TextEntry::make('items')
                            ->label('')
                            ->formatStateUsing(function ($record) {
                                $items = $record->items;
                                if ($items->isEmpty()) {
                                    return ($record->product?->name ?? '-') . ' × ' . $record->quantity_sold . ' @ ' . number_format($record->selling_price ?? 0) . ' RWF';
                                }
                                return $items->map(fn ($item) =>
                                    ($item->product?->name ?? '-') . ' × ' . $item->quantity_sold . ' @ ' . number_format($item->unit_price) . ' RWF = ' . number_format($item->line_total) . ' RWF'
                                )->join("\n");
                            }),
                    ]),
            ]);
    }
}
