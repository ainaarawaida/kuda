<?php

namespace App\Models;

use App\Models\Slot;
use App\Models\User;
use App\Models\Rider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coach extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];


    public function slots()
    {
        // return $this->belongsToMany(Slot::class, 'coach_slot', 'slot_id', 'coach_id');
        // return $this->belongsToMany(Slot::class, 'coach_slot', 'slot_id', 'coach_id')->withPivot(['rider_id']);
        return $this->belongsToMany(Slot::class, 'coach_slot', 'coach_id', 'slot_id')->withPivot(['rider_id']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rider()
    {
        // return $this->belongsTo(Rider::class);
        return $this->belongsToMany(Rider::class, 'coach_slot', 'coach_id', 'rider_id')->withPivot(['rider_id']);
    }

    public function getRiderForCoachAttribute()
    {
        $rider_id = $this->rider_id ;
        $rider = Rider::where('id', $rider_id)->first();
        return $rider->name ?? '' ;
        // dump($this->coach()->withPivot(['rider_id'])->get()->first()->pivot->rider_id);
        // dump($this->coach()->pluck('coach_id'));
        // dd($this->coach()->get()->toArray());
        // return $this->id ;
    }
}
 