<?php

namespace App\Models\Guard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuardInternalService extends Model
{
    use softDeletes;

    protected $fillable = [
        'report_id',
        'type_id',
        'employee_id',
        'start_time',
    ];
}
