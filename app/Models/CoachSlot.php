<?php

namespace App\Models;

use App\Models\Slot;
use App\Models\Coach;
use App\Models\Horse;
use App\Models\Rider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoachSlot extends Model
{
    use HasFactory;
    public $table = 'coach_slot';


    public function horses()
    {
        return $this->belongsTo(Horse::class,'horse_id');
    }

    public function coaches()
    {
        return $this->belongsTo(Coach::class,'coach_id');
    }

    public function slots()
    {
        return $this->belongsTo(Slot::class,'slot_id');
    }

    public function riders()
    {
        return $this->belongsTo(Rider::class,'rider_id');
    }

    public function getTimeAttribute()
    {
        return Time::find($this->slots()->first()->time_id)->name;
    }


}
