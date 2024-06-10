<?php

namespace App\Filament\Aluno\Resources\CoisaResource\Pages;

use App\Filament\Aluno\Resources\CoisaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoisas extends ListRecords
{
    protected static string $resource = CoisaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
