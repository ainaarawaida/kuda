<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horse extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function slots()
    {
        return $this->belongsToMany(Slot::class, 'coach_slot', 'horse_id', 'slot_id')->withPivot(['id','rider_id', 'coach_id']);
    }

    public function coach()
    {
        return $this->belongsToMany(Coach::class, 'coach_slot', 'horse_id', 'coach_id')->withPivot(['rider_id', 'slot_id']);
    }

    public function rider()
    {
        return $this->belongsToMany(Rider::class, 'coach_slot', 'horse_id', 'rider_id')->withPivot(['coach_id', 'slot_id']);
    }

    public function horses()
    {
        return $this->belongsToMany(Horse::class, 'coach_slot', 'slot_id', 'horse_id')->withPivot(['rider_id', 'coach_id']);
    }

    public function getCoachForHorseAttribute()
    {
        $coach = Coach::where('id', $this->coach_id)?->first()?->name ;
        return $coach ;
    }

    public function getRiderForHorseAttribute()
    {
        $rider = Rider::where('id', $this->rider_id)?->first()?->name ;
        return $rider ;
    }
}
