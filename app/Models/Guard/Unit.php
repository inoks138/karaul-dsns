<?php

namespace App\Models\Guard;

use App\Models\Emergency\EmergencyLiquidation;
use App\Models\Employee\Employee;
use App\Models\Vehicle\Vehicle;
use App\Models\Workplace\Firehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
//    use softDeletes;

    protected $fillable = [
        'guard_id',
        'number',
        'commander_id',
        'driver_id',
        'vehicle_id',
    ];

    public function firehouseGuard(): BelongsTo
    {
        return $this->belongsTo(Guard::class);
    }

    public function commander(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function firefighters(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'firefighters_units', 'unit_id', 'firefighter_id');
    }

    public function emergencyLiquidations(): HasMany
    {
        return $this->hasMany(EmergencyLiquidation::class, 'unit_id', 'id');
    }

    public function activeEmergencyLiquidation(): HasOne
    {
        return $this->hasOne(EmergencyLiquidation::class, 'unit_id', 'id')
            ->whereNotNull('returned_at')
            ->orderBy('created_at', 'desc');
    }
}
