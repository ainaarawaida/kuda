<?php

namespace App\Filament\Resources\CustomMediaResource\Pages;

use App\Filament\Resources\CustomMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomMedia extends EditRecord
{
    protected static string $resource = CustomMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
