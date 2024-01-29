<?php

namespace App\Filament\Rider\Resources;

use Filters\Date;
use Filament\Forms;
use App\Models\Slot;
use App\Models\Time;
use Filament\Tables;
use App\Models\Coach;
use App\Models\Horse;
use App\Models\Ktime;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Rider\Resources\SlotResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Rider\Resources\SlotResource\RelationManagers;
use App\Filament\Rider\Resources\SlotResource\RelationManagers\CoachRelationManager;
use App\Filament\Rider\Resources\SlotResource\RelationManagers\HorsesRelationManager;

class SlotResource extends Resource
{
    protected static ?string $model = Slot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Class Name')   
                ->maxLength(255)
                ->disabled(),
                Forms\Components\DatePicker::make('date')->default(now())
                ->required()
                ->live()
                ->disabled(),
                Select::make('time_id') 
                ->label('Time')   
                ->options(function (Get $get, $operation){
          
                    if($operation == 'edit'){
                           
                        $findSlotNotAvailable = Slot::where('date', $get('date'))->get()->pluck('time_id')->toArray();
                        $availableTime = Time::whereNotIn('id', $findSlotNotAvailable)
                        ->orWhere('id', $get('time_id'))
                        ->get()->pluck('name', 'id');
                        return $availableTime ;

                    }else{
                        $findSlotNotAvailable = Slot::where('date', $get('date'))->get()->pluck('time_id')->toArray();
                        $availableTime = Time::whereNotIn('id', $findSlotNotAvailable)->get()->pluck('name', 'id');
                        return $availableTime ;
                    }
                })
                ->required()
                ->live()
                ->disabled(),
                // Select::make('coach_id')
                // ->multiple()
                // ->relationship('coach','name')
                // ->options(function (Get $get, $operation){
          
                //     if($operation == 'edit'){
                           
                //         // $findSlotNotAvailable = Slot::where('date', $get('date'))->get()->pluck('time_id')->toArray();
                //         // $availableTime = Time::whereNotIn('id', $findSlotNotAvailable)
                //         // ->orWhere('id', $get('time_id'))
                //         // ->get()->pluck('name', 'id');
                //         // return $availableTime ;

                //         $user = Coach::get()->pluck('name', 'id');
                //         return $user;

                //     }else{
                //         // $coach = Coach::get();
                //         // // $pivotData = $coach->first();
                //         // dd($coach);
                //         // $slot = Slot::where('date',$get('date'))
                //         // // where('time_id', $get('time_id'))
                //         // // ->where('date',$get('date'))
                //         // ->get();
                //         // dd($slot);


                //         // $findCoach = Slot::wherePivot('slot_id', $slotId)->pluck('coach_id')->toArray();
                //         // $user = Coach::whereIn('id', $findCoach)->get()->pluck('name', 'id');

                //         $user = Coach::get()->pluck('name', 'id');
                //         return $user;
                //     }
                // })
                // ->preload(),
                // Select::make('rider_id')
                // ->relationship('rider','rider_id')
                // ->preload()
               
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('horses.name')
                ->badge()
                ->color('danger')
                ->label('Riders')   
                ->searchable(),
                Tables\Columns\TextColumn::make('rider.name')
                ->badge()
                ->color('info')
                ->label('Riders')   
                ->searchable(),

                Tables\Columns\TextColumn::make('coach.name')
                ->badge()
                ->color('primary')
                ->label('Coaches')   
                ->searchable(),

                Tables\Columns\TextColumn::make('name')
                ->label('Class Name')   
                ->searchable(),
                Tables\Columns\TextColumn::make('time.name')
           
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
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
                // Tables\Filters\TrashedFilter::make(),
                Filter::make('date')
                    ->form([
                        DatePicker::make('date_at')
                        ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_at'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '=', $date),
                            );
                    }),
                SelectFilter::make('Horse')
                ->relationship('horses', 'name')
                ->searchable()
                ->preload()
                ->label('Filter by Horse')
                ->indicator('Horse'),

                
                SelectFilter::make('Coach')
                ->relationship('coach', 'name')
                ->searchable()
                ->preload()
                ->label('Filter by Coach')
                ->indicator('Coach'),

                SelectFilter::make('Rider')
                ->relationship('rider', 'name')
                ->searchable()
                ->preload()
                ->label('Filter by Rider')
                ->indicator('Rider'),

                    
            ])
            ->recordUrl(function ($record) {
                return false;
            })
            ->recordAction(null)
            ->actions([
                Tables\Actions\EditAction::make()
                ->label('Check'),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            // CoachRelationManager::class,
            HorsesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSlots::route('/'),
            'create' => Pages\CreateSlot::route('/create'),
            'edit' => Pages\EditSlot::route('/{record}/edit'),
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
