<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Time;
use App\Models\User;
use Filament\Tables;
use App\Models\Coach;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CoachResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CoachResource\RelationManagers;

class CoachResource extends Resource
{
    protected static ?string $model = Coach::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Select::make('user_id')
                    ->label('User')   
                    ->options(function (Get $get, $operation){
                        if($operation == 'edit'){
                            // $user = User::role('coach')->orWhere('id', $get('user_id'))->doesntHave('coach')->get()->pluck('name', 'id');
                            // $user = User::role('coach')->where('id', $get('user_id'))->get()->pluck('name', 'id');
                            $availableUser = User::role('coach')->doesntHave('coach')->get()->pluck('id');
                            $user = User::whereIn('id', $availableUser)->orWhere('id', $get('user_id'))->get()->pluck('name', 'id');
                            return $user ;
                            // $findSlotNotAvailable = Slot::where('date', $get('date'))->get()->pluck('time_id')->toArray();
                            // $availableTime = Time::whereNotIn('id', $findSlotNotAvailable)
                            // ->orWhere('id', $get('time_id'))
                            // ->get()->pluck('name', 'id');
                            // return $availableTime ;

                        }else{
                            $user = User::doesntHave('coach')->role('coach')->get()->pluck('name', 'id');
                            return $user;
                        }
                    })
                    ->required()
                    ->preload(),


                Forms\Components\TextInput::make('name')
                    ->label('Name')   
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('notel')
                    ->label('No Tel')   
                    ->tel()
                    ->maxLength(255)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('notel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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
            'index' => Pages\ListCoaches::route('/'),
            'create' => Pages\CreateCoach::route('/create'),
            'edit' => Pages\EditCoach::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
