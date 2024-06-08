<?php

namespace App\Models\Emergency;

use App\Models\Employee\Employee;
use App\Models\Guard\Unit;
use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyComment extends Model
{
    use softDeletes;

    protected $fillable = [
        'emergency_id',
        'employee_id',
        'comment',
    ];

    public function emergency(): BelongsTo
    {
        return $this->belongsTo(Emergency::class, 'emergency_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
