<?php

namespace App\Filament\Coach\Resources\SlotResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Coach\Resources\SlotResource;

class EditSlot extends EditRecord
{
    protected static string $resource = SlotResource::class;

    protected static ?string $title = 'Check Slot';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
            // Actions\ForceDeleteAction::make(),
            // Actions\RestoreAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    // public function getTitle(): string | Htmlable
    // {
    //     if (filled(static::$title)) {
    //         return static::$title;
    //     }

    //     return __('filament-panels::resources/pages/edit-record.title', [
    //         'label' => $this->getRecordTitle(),
    //     ]);
    // }
}
