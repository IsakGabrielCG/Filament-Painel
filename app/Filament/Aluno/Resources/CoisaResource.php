<?php

namespace App\Filament\Aluno\Resources;

use App\Filament\Aluno\Resources\CoisaResource\Pages;
use App\Filament\Aluno\Resources\CoisaResource\RelationManagers;
use App\Models\Coisa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoisaResource extends Resource
{
    protected static ?string $model = Coisa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListCoisas::route('/'),
            'create' => Pages\CreateCoisa::route('/create'),
            'edit' => Pages\EditCoisa::route('/{record}/edit'),
        ];
    }
}
