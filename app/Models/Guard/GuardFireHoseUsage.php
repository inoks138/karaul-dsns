<?php

namespace App\Models\Guard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuardFireHoseUsage extends Model
{
    use softDeletes;

    protected $fillable = [
        'report_id',
        'diameter',
        'hose_number',
        'work_time_seconds',
    ];
}
