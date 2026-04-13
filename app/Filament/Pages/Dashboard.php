<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('period')
                            ->label('Quick Select')
                            ->options([
                                'today' => 'Today',
                                'yesterday' => 'Yesterday',
                                'last_7_days' => 'Last 7 Days',
                                'last_30_days' => 'Last 30 Days',
                                'this_month' => 'This Month',
                                'last_month' => 'Last Month',
                                'this_year' => 'This Year',
                                'all_time' => 'All Time',
                            ])
                            ->default('all_time')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $dates = match ($state) {
                                    'today' => [now()->startOfDay(), now()->endOfDay()],
                                    'yesterday' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()],
                                    'last_7_days' => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
                                    'last_30_days' => [now()->subDays(29)->startOfDay(), now()->endOfDay()],
                                    'this_month' => [now()->startOfMonth(), now()->endOfMonth()],
                                    'last_month' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
                                    'this_year' => [now()->startOfYear(), now()->endOfYear()],
                                    default => [null, null],
                                };
                                $set('start_date', $dates[0]?->format('Y-m-d'));
                                $set('end_date', $dates[1]?->format('Y-m-d'));
                            }),
                        DatePicker::make('start_date')
                            ->label('From')
                            ->live(),
                        DatePicker::make('end_date')
                            ->label('To')
                            ->live(),
                    ])
                    ->columns(3),
            ]);
    }
}
