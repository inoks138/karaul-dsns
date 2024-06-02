<?php

namespace App\Models\Workplace;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firehouse extends Model
{
    use softDeletes;

    protected $fillable = [
        'detachment_id',
        'number',
        'address',
    ];

    public function detachment(): BelongsTo
    {
        return $this->belongsTo(Detachment::class);
    }

    public function employees(): MorphMany
    {
        return $this->morphMany(Employee::class, 'workplace');
    }
}
