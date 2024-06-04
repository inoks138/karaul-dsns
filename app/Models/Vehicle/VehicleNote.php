<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleNote extends Model
{
    use softDeletes;

    protected $fillable = [
        'vehicle_id',
        'guard_id',
        'state_id',
        'state_comment',
        'fuel',
        'fire_extinguishing_equipment',
    ];
}
