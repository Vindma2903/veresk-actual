<?php

namespace App\Filament\Resources\SiteOptionResource\Pages;

use App\Filament\Resources\SiteOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiteOption extends EditRecord
{
    protected static string $resource = SiteOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
