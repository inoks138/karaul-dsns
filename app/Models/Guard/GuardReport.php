<?php

namespace App\Models\Guard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuardReport extends Model
{
    use softDeletes;

    protected $fillable = [
        'guard_id',
        'chief_id',
        'dispatcher_id',
        'vacation_employees_count',
        'sick_employees_count',

        'business_trip_employees_count',
        'stock_employees_count',
        'service_inspection',
        'malfunctions',
    ];
}
