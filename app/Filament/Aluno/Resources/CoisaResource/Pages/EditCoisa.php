<?php

namespace App\Filament\Aluno\Resources\CoisaResource\Pages;

use App\Filament\Aluno\Resources\CoisaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoisa extends EditRecord
{
    protected static string $resource = CoisaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
