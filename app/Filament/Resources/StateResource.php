<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\RelationManagers\EmployeesRelationManager;
use App\Filament\Resources\StateResource\Pages;
use App\Filament\Resources\StateResource\RelationManagers;
use App\Filament\Resources\StateResource\RelationManagers\CitiesRelationManager;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationLabel = 'State'; // change the label in the sidebar

    protected static ?string $modelLabel = 'States'; // change the label in the form

    protected static ?string $navigationGroup = 'System Management'; // create the group in the sidebar

    protected static ?int $navigationSort = 2; // change the order in the sidebar



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('country_id')
                    ->relationship(name: 'country', titleAttribute: 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('State Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->numeric()
                    ->searchable()
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist 
        ->schema([
            Section::make('State Info')
            ->schema([
                TextEntry::make('country.name')->label('Country Name'),
                TextEntry::make('name')->label('State Name'),
            ])->columns(2)
        ]);
    }
    

    public static function getRelations(): array
    {
        return [
            CitiesRelationManager::class,
            EmployeesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
}
