<?php

namespace App\Filament\Resources\CountryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Illuminate\Support\Collection;
use Filament\Forms\Get;
use App\Models\State;
use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Relationships')
                ->schema([
                    Forms\Components\Select::make('country_id')
                        ->relationship(name: 'country', titleAttribute: 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function (Set $set) {
                            $set('state_id', null);
                            $set('city_id', null);
                        })
                        ->native(false),
                    Forms\Components\Select::make('state_id')
                        ->options(fn (Get $get): Collection => State::query()
                            ->where('country_id', $get('country_id'))
                            ->pluck('name', 'id'))
                        ->required()
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
                        ->preload()
                        ->native(false),
                    Forms\Components\Select::make('city_id')
                        ->options(fn (Get $get): Collection => City::query()
                            ->where('state_id', $get('state_id'))
                            ->pluck('name', 'id'))
                        ->required()
                        ->searchable()
                        ->live()
                        ->preload()
                        ->native(false),
                    Forms\Components\Select::make('department_id')
                        ->relationship(name: 'department', titleAttribute: 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->native(false),

                ])->columns(2),

            Forms\Components\Section::make('User Name')
                ->description('Please enter the user name details')
                ->schema([
                    Forms\Components\TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('middle_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->maxLength(255),


                ])->columns(3),

            Forms\Components\Section::make('User Address')
                ->description('Please enter the user address details')
                ->schema([
                    Forms\Components\TextInput::make('address')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('zip_code')
                        ->required()
                        ->maxLength(255),
                ])->columns(2),

            Forms\Components\Section::make('Dates')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zip_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_hired')
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
