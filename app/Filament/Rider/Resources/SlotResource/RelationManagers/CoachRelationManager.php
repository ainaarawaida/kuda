<?php

namespace App\Filament\Rider\Resources\SlotResource\RelationManagers;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Coach;
use App\Models\Rider;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CoachRelationManager extends RelationManager
{
    protected static string $relationship = 'coach';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
              
                  
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->allowDuplicates(false) 
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('rider_for_coach'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                // ->preloadRecordSelect()
                ->form(fn (AttachAction $action, $record): array => [
                    $action->getRecordSelect()
                        ->options(function (Get $get, $operation, RelationManager $livewire){
                            if($operation == 'attach'){
                                $coachAttached = DB::table('coach_slot')
                                        ->where('slot_id', $livewire->ownerRecord->id)
                                        ->get()->pluck('coach_id')->toArray();
                                   $availableCoach = Coach::whereNotIn('id', $coachAttached)->pluck('name', 'id');     
                                    return $availableCoach;
                                }
                        })
                        ->required()
                        ->preload(),
                        // ->rules([
                        //     function (RelationManager $livewire, Get $get) {
                        //         $registrant = $livewire->ownerRecord;
                        //         return function (string $attribute, $value, \Closure $fail) use ($registrant) {
                        //             $flightExists = DB::table('client_flight')
                        //             ->where('client_id', $registrant->id)
                        //             ->where('flight_id', $value)->first();
                        //             if ($flightExists) {
                        //                 $fail("This code already exists on this registrant record.");
                        //             }
                        //         };
                        //     },
                        // ]),
                        
                   
                    Select::make('rider_id')
                    ->label('Rider')   
                    ->relationship('rider', 'name')
                    ->options(function (Get $get, $operation, RelationManager $livewire){
                        if($operation == 'attach'){
                        $riderAttached = DB::table('coach_slot')
                                ->where('slot_id', $livewire->ownerRecord->id)
                                ->get()->pluck('rider_id')->toArray();
                           $availableRider = Rider::whereNotIn('id', $riderAttached)->pluck('name', 'id');     
                            return $availableRider;
                        }
                    })
                    ->preload()
                    // ->saveRelationshipsUsing(function ($record, $state) {
                       
                    //     $record->rider()->sync($state);
                    // })
                    
                ])
               
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->form(fn ($action, $record): array => [
                    Select::make('rider_id')
                    ->label('Rider')   
                    // ->relationship('rider', 'name')
                    ->options(function (Get $get, $operation, RelationManager $livewire){
                        // dd($operation);
                        if($operation == 'edit'){
                        $riderAttached = DB::table('coach_slot')
                                ->where('slot_id', $livewire->ownerRecord->id)
                                ->get()->pluck('rider_id')->toArray();
                           $availableRider = Rider::whereNotIn('id', $riderAttached)->pluck('name', 'id');     
                            return $availableRider;
                        }
                    })
                    ->preload()
                ])
                ->using(function (Model $record, array $data): Model {
                    // dump($record);
                    // $record->pivot_rider_id = $data['rider_id'];
                    // $record->rider_id = $data['rider_id'];
                    // dump($record);
                    // dd($data);
                    // $record->update($data);
                    DB::table('coach_slot')
                        ->where('slot_id', $record->slot_id)
                        ->where('coach_id', $record->coach_id)
                        ->update([
                            'rider_id' => $data['rider_id'],
                    ]);
                    return $record;
                })
                ,
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
