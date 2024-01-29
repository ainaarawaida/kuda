<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CustomMedia;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Awcodes\Curator\Resources\MediaResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomMediaResource\Pages;
use App\Filament\Resources\CustomMediaResource\RelationManagers;

class CustomMediaResource extends MediaResource
{
    public static function canAccess(): bool
    {
        return false;
    }
}
