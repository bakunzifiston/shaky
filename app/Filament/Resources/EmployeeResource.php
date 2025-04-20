<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('position')
                ->maxLength(255)
                ->default(null),

            TextInput::make('phone')
                ->tel()
                ->maxLength(255)
                ->default(null),

            TextInput::make('email')
                ->email()
                ->maxLength(255)
                ->default(null),

                Select::make('province')
                ->label('Province')
                ->options([
                    'Kigali City' => 'Kigali City',
                    'Northern' => 'Northern',
                    'Southern' => 'Southern',
                    'Eastern' => 'Eastern',
                    'Western' => 'Western',
                ])
                ->reactive()
                ->afterStateUpdated(function (callable $set) {
                    $set('district', null); // reset district on province change
                }),
            
            Select::make('district')
                ->label('District')
                ->options(function (callable $get) {
                    $province = $get('province');
                    return match ($province) {
                        'Kigali City' => [
                            'Gasabo' => 'Gasabo',
                            'Kicukiro' => 'Kicukiro',
                            'Nyarugenge' => 'Nyarugenge',
                        ],
                        'Northern' => [
                            'Musanze' => 'Musanze',
                            'Gicumbi' => 'Gicumbi',
                            'Burera' => 'Burera',
                            'Rulindo' => 'Rulindo',
                            'Gakenke' => 'Gakenke',
                        ],
                        'Southern' => [
                            'Huye' => 'Huye',
                            'Muhanga' => 'Muhanga',
                            'Nyanza' => 'Nyanza',
                            'Gisagara' => 'Gisagara',
                            'Nyamagabe' => 'Nyamagabe',
                            'Nyaruguru' => 'Nyaruguru',
                            'Kamonyi' => 'Kamonyi',
                        ],
                        'Eastern' => [
                            'Rwamagana' => 'Rwamagana',
                            'Kayonza' => 'Kayonza',
                            'Ngoma' => 'Ngoma',
                            'Kirehe' => 'Kirehe',
                            'Bugesera' => 'Bugesera',
                            'Nyagatare' => 'Nyagatare',
                            'Gatsibo' => 'Gatsibo',
                        ],
                        'Western' => [
                            'Rubavu' => 'Rubavu',
                            'Rusizi' => 'Rusizi',
                            'Nyamasheke' => 'Nyamasheke',
                            'Karongi' => 'Karongi',
                            'Rutsiro' => 'Rutsiro',
                            'Ngororero' => 'Ngororero',
                            'Nyabihu' => 'Nyabihu',
                        ],
                        default => [],
                    };
                })
                ->required()
                ->disabled(fn (callable $get) => $get('province') === null),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('position')->searchable(),
                Tables\Columns\TextColumn::make('phone')
                ->searchable()
                ->icon('heroicon-m-phone'),
                Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->icon('heroicon-m-envelope'),
            
                Tables\Columns\TextColumn::make('province')->label('Province'),
                Tables\Columns\TextColumn::make('district')->label('District'),
                
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
