<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rider extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slots()
    {
        return $this->belongsToMany(Slot::class, 'coach_slot', 'rider_id', 'slot_id')->withPivot(['coach_id']);
    }

    public function coach()
    {
        return $this->belongsToMany(Slot::class, 'coach_slot', 'rider_id', 'coach_id')->withPivot(['slot_id']);
    }
}
