<?php

namespace App\Filament\Resources\CoachSlotResource\Pages;

use App\Filament\Resources\CoachSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoachSlot extends EditRecord
{
    protected static string $resource = CoachSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
