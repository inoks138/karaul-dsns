<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
