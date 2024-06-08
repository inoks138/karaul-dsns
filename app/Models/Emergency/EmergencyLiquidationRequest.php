<?php

namespace App\Models\Emergency;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyLiquidationRequest extends Model
{
    use softDeletes;

    protected $fillable = [
        'emergency_id',
        'firehouse_id',
        'is_accepted',
        'decline_comment',
    ];

    public function emergency(): BelongsTo
    {
        return $this->belongsTo(Emergency::class, 'emergency_id', 'id');
    }
}
