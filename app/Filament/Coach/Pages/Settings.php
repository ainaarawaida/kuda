<?php

namespace App\Filament\Coach\Pages;

use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Custom Page Title';
    protected static string $view = 'filament.pages.settings';


    public static function canAccess(): bool
    {
        return false;
    }
    
}
