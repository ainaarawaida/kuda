<?php

namespace App\Filament\Resources\CustomMediaResource\Pages;

use App\Filament\Resources\CustomMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomMedia extends ListRecords
{
    protected static string $resource = CustomMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
