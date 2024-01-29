<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoachSlotResource\Pages;
use App\Filament\Resources\CoachSlotResource\RelationManagers;
use App\Models\CoachSlot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoachSlotResource extends Resource
{
    protected static ?string $model = CoachSlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): string
    {
        return 'Slot Details'; // Replace with your desired title
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('horse_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('coach_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('slot_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('rider_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slots.date')
                ->label('Slot Date')
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->label('Slot Time')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('horses.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coaches.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slots.name')
                    ->numeric()
                    ->sortable(),
              
                Tables\Columns\TextColumn::make('riders.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->recordUrl(function ($record) {
                return false;
            })
            ->recordAction(null)
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoachSlots::route('/'),
            'create' => Pages\CreateCoachSlot::route('/create'),
            'edit' => Pages\EditCoachSlot::route('/{record}/edit'),
        ];
    }
}
