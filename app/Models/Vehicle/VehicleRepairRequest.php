<?php

namespace App\Models\Vehicle;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleRepairRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'submitted_by',
        'comment',
        'approved_at',
        'declined_at',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'submitted_by', 'id');
    }
}
