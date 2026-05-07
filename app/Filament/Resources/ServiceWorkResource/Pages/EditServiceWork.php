<?php

namespace App\Filament\Resources\ServiceWorkResource\Pages;

use App\Filament\Resources\ServiceWorkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceWork extends EditRecord
{
    protected static string $resource = ServiceWorkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
