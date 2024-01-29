<?php

namespace App\Filament\Coach\Resources\SlotResource\RelationManagers;

use Filament\Forms;
use App\Models\Slot;
use Filament\Tables;
use App\Models\Coach;
use App\Models\Horse;
use App\Models\Rider;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\CoachSlot;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class HorsesRelationManager extends RelationManager
{
    protected static string $relationship = 'horses';

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Select::make('horse_id')
    //             ->label('Horse')   
    //             ->relationship('horses', 'name')
    //             ->options(function (Get $get, $operation, RelationManager $livewire, $record){
    //                 $horseAttached = Slot::find($livewire->ownerRecord->id)->horses()->get()->pluck('id')->toArray();  
    //                 $filteredArray = array_filter($horseAttached, function($value) {
    //                     return !is_null($value);
    //                 });
    //                 $availableHorse = Horse::whereNotIn('id', $filteredArray)
    //                 ->orWhere('id', $record['horse_id'])->pluck('name', 'id');     
    //                 return $availableHorse;
    //             })
    //             ->preload()
    //             ->required()
    //             ->live()
    //             ->afterStateUpdated(function (Set $set) {
    //                 $set('coach_id', null);
    //                 $set('rider_id', null);
    //             })
    //             ,
    //             Select::make('coach_id')
    //             ->label('Coach')   
    //             ->relationship('coach', 'name')
    //             ->options(function (Get $get, $operation, RelationManager $livewire, $record){
    //                 $coachAttached = Slot::find($livewire->ownerRecord->id)->coach()->get()->pluck('id')->toArray();  
    //                 $filteredArray = array_filter($coachAttached, function($value) {
    //                     return !is_null($value);
    //                 });
    //                 $availablecoach = Coach::whereNotIn('id', $filteredArray)
    //                 ->orWhere('id', $record['coach_id'])->pluck('name', 'id');     
    //                 return $availablecoach;
                   
    //             })
    //             ->preload()
    //             ->live()
    //             ->afterStateUpdated(function (Set $set) {
    //                 $set('rider_id', null);
    //             })
    //             ,
    //             Select::make('rider_id')
    //             ->label('Rider')   
    //             ->relationship('rider', 'name')
    //             ->options(function (Get $get, $operation, RelationManager $livewire, $record){
    //                 $riderAttached = Slot::find($livewire->ownerRecord->id)->rider()->get()->pluck('id')->toArray();  
    //                 $filteredArray = array_filter($riderAttached, function($value) {
    //                     return !is_null($value);
    //                 });
    //                 $availablerider = Rider::whereNotIn('id', $filteredArray)
    //                 ->orWhere('id', $record['rider_id'])->pluck('name', 'id');     
    //                 return $availablerider;
                   
    //             })
    //             ->preload()
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Horse'),
                Tables\Columns\TextColumn::make('coach_for_horse')
                ->label('Coach') ,
                Tables\Columns\TextColumn::make('rider_for_horse')
                ->label('Rider') ,
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\Action::make('attach')
                // ->label('Attach Horse') 
                // ->form([
                 
                //     Select::make('horse_id')
                //     ->label('Horse')   
                //     ->relationship('horses', 'name')
                //     ->options(function (Get $get, $operation, RelationManager $livewire){
                        
                //         $horseAttached = Slot::find($livewire->ownerRecord->id)->horses()->get()->pluck('id')->toArray();  
                //         $filteredArray = array_filter($horseAttached, function($value) {
                //             return !is_null($value);
                //         });
                //         $availableHorse = Horse::whereNotIn('id', $filteredArray)->pluck('name', 'id');     
                //         return $availableHorse;
                //     })
                //     ->preload()
                //     ->required()
                //     ->live()
                //     ->afterStateUpdated(function (Set $set) {
                //         $set('coach_id', null);
                //         $set('rider_id', null);
                //     })
                //     ,
                //     Select::make('coach_id')
                //     ->label('Coach')   
                //     ->relationship('coach', 'name')
                //     ->options(function (Get $get, $operation, RelationManager $livewire){
                //         $coachAttached = Slot::find($livewire->ownerRecord->id)->coach()->get()->pluck('id')->toArray();  
                //         $filteredArray = array_filter($coachAttached, function($value) {
                //             return !is_null($value);
                //         });
                //         $availablecoach = Coach::whereNotIn('id', $filteredArray)->pluck('name', 'id');       
                //         return $availablecoach;
                       
                //     })
                //     ->preload()
                //     ->live()
                //     ->afterStateUpdated(function (Set $set) {
                //         $set('rider_id', null);
                //     })
                //     ,
                //     Select::make('rider_id')
                //     ->label('Rider')   
                //     ->relationship('rider', 'name')
                //     ->options(function (Get $get, $operation, RelationManager $livewire){
                //         $riderAttached = Slot::find($livewire->ownerRecord->id)->rider()->get()->pluck('id')->toArray();  
                //         $filteredArray = array_filter($riderAttached, function($value) {
                //             return !is_null($value);
                //         });
                //         $availablerider = Rider::whereNotIn('id', $filteredArray)->pluck('name', 'id');     
                //         return $availablerider;
                       
                //     })
                //     ->preload()
                   
                // ])
                // ->action(function (RelationManager $livewire, $data) {
                //     $slot = Slot::find($livewire->ownerRecord->id) ;
                //     $slot->coach()->attach($data['coach_id'], ['rider_id' => $data['rider_id'], 'horse_id' => $data['horse_id']]);
                   
                // }),
            ])
          
            ->recordAction(null)
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DetachAction::make(),
                Tables\Actions\Action::make('Booking Coach')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->hidden(function($record, $livewire){
                        $coach = Coach::where('user_id', Auth::user()->id)->first();
                        if($coach){
                            if($record->coach_id){
                                return true;
                            }
                            return false ;
                           
                        }
                       
                        return true;
                       
                    })
                    ->requiresConfirmation(function (Tables\Actions\Action $action, $record, RelationManager $livewire) {
                        // dd($livewire);
                        $action->modalDescription('Are you sure you want to become coach for this slot '. $livewire->ownerRecord->name .'?');
                        $action->modalHeading('Set slot "' . $livewire->ownerRecord->name . '" as coach');

                        return $action;
                    })
                    ->action(function ($record, $data, $livewire) {
                        $couch = Coach::where('user_id', Auth::user()->id)->first() ;
                        CoachSlot::where('id', $record->pivot_id)
                        ->update(['coach_id' => $couch->id]);
                        
                    }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
