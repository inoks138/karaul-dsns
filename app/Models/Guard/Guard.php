<?php

namespace App\Models\Guard;

use App\Models\Employee\Employee;
use App\Models\Workplace\Firehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guard extends Model
{
    use softDeletes;

    protected $fillable = [
        'firehouse_id',
        'date_of_service',
        'start_time',
        'end_time',
        'chief_id',
        'dispatcher_id',
    ];

    public function firehouse(): BelongsTo
    {
        return $this->belongsTo(Firehouse::class);
    }

    public function chief(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function dispatcher(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getPrevious(): ?Guard
    {
        return self::query()
            ->where('firehouse_id', $this->firehouse_id)
            ->where('start_time', '<', $this->start_time)
            ->orderBy('start_time', 'desc')
            ->first();
    }
}
