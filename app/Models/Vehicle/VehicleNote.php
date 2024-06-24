<?php

namespace App\Models\Vehicle;

use App\Models\Guard\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function guard(): BelongsTo
    {
        return $this->belongsTo(Guard::class, 'guard_id', 'id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(VehicleNoteState::class, 'state_id', 'id');
    }
}
