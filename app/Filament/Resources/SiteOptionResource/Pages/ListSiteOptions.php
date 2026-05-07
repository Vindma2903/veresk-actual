<?php

namespace App\Filament\Resources\SiteOptionResource\Pages;

use App\Filament\Resources\SiteOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteOptions extends ListRecords
{
    protected static string $resource = SiteOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
