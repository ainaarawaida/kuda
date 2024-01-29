<?php

namespace App\Models;

use App\Models\Time;
use App\Models\Coach;
use App\Models\Ktime;
use App\Models\Rider;
use App\Models\CoachSlot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function time()
    {
        return $this->belongsTo(Time::class);
    }

    public function coach()
    {
        // return $this->belongsToMany(Coach::class, 'coach_slot', 'slot_id', 'coach_id');
        return $this->belongsToMany(Coach::class, 'coach_slot', 'slot_id', 'coach_id')->withPivot(['rider_id']);
    }

    public function horses()
    {
        return $this->belongsToMany(Horse::class, 'coach_slot', 'slot_id', 'horse_id')->withPivot(['id', 'rider_id', 'coach_id']);
    }

    public function rider()
    {
        return $this->belongsToMany(Rider::class, 'coach_slot', 'slot_id', 'rider_id')->withPivot(['coach_id','horse_id']);
    }

    public function getRiderForCoachAttribute()
    {
        dd($this->getAttributes());
        $coach = Coach::where('id', $this->coach_id)?->first()?->name ;
        return $coach ;

        $rider_id = $this->coach()?->withPivot(['rider_id'])?->get()?->first()?->pivot->rider_id ;
        $rider = Rider::where('id', $rider_id)->first();
        return $rider->name ?? '' ;
      
    }

    public function getCoachForSlotAttribute()
    {
        // $rider_id = $this->coach()?->withPivot(['rider_id'])?->get()?->first()?->pivot->rider_id ;
        // $rider = Rider::where('id', $rider_id)->first();
        // return $rider->name ?? '' ;
        dd($this->getAttributes());
        $coach = Coach::where('id', $this->coach_id)?->first()?->name ;
        return $coach ;

        $coach_id = $this->coach()?->withPivot(['rider_id'])?->pluck('id') ;
        return $coach_id ?? [] ;
      
    }


}
