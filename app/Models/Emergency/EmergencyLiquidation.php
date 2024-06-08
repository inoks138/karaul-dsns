<?php

namespace App\Models\Emergency;

use App\Models\Guard\Unit;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyLiquidation extends Model
{
    use softDeletes;

    protected $fillable = [
        'emergency_id',
        'unit_id',
        'vehicle_id',
        'departured_at',
        'arrived_at',
        'first_barrel_delivered_at',
        'localized_at',
        'liquidated_at',
        'returned_at',
        'fire_square',
        'fire_square_after_localization',
    ];

    public function emergency(): BelongsTo
    {
        return $this->belongsTo(Emergency::class, 'emergency_id', 'id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
