<?php

namespace App\Filament\Rider\Resources\SlotResource\RelationManagers;

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
            ])
          
            ->recordAction(null)
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DetachAction::make(),
                Tables\Actions\Action::make('Booking Rider')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->hidden(function($record, $livewire){
                        $rider = Rider::where('user_id', Auth::user()->id)->first();
                        if($rider){
                            if($record->rider_id){
                                return true;
                            }
                            return false ;
                           
                        }
                       
                        return true;
                       
                    })
                    ->requiresConfirmation(function (Tables\Actions\Action $action, $record, RelationManager $livewire) {
                        // dd($livewire);
                        $action->modalDescription('Are you sure you want to become rider for this slot '. $livewire->ownerRecord->name .'?');
                        $action->modalHeading('Set slot "' . $livewire->ownerRecord->name . '" as rider');

                        return $action;
                    })
                    ->action(function ($record, $data, $livewire) {
                        $rider = Rider::where('user_id', Auth::user()->id)->first() ;
                        CoachSlot::where('id', $record->pivot_id)
                        ->update(['rider_id' => $rider->id]);
                        
                    }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
