<?php

namespace App\Filament\Resources\CoachSlotResource\Pages;

use App\Filament\Resources\CoachSlotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoachSlots extends ListRecords
{
    protected static string $resource = CoachSlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
