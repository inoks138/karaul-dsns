<?php

namespace App\Models\Emergency;

use App\Models\Workplace\Detachment;
use App\Models\Workplace\Firehouse;
use App\Models\Workplace\Headquarter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emergency extends Model
{
    use softDeletes;

    protected $fillable = [
        'dispatcher_id',
        'type_id',
        'address',
        'comment',
        'reporter_workplace_id',
        'reporter_workplace_type',
        'reporter_id',
        'reported_at',
        'closed_at',
    ];

    public function reporterWorkplace(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(EmergencyType::class, 'type_id', 'id');
    }

    public function liquidations(): HasMany
    {
        return $this->hasMany(EmergencyLiquidation::class, 'emergency_id', 'id');
    }

    public function liquidationRequests(): HasMany
    {
        return $this->hasMany(EmergencyLiquidationRequest::class, 'emergency_id', 'id');
    }

    public function liquidationRequest(): HasOne
    {
        return $this->hasOne(EmergencyLiquidationRequest::class, 'emergency_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(EmergencyComment::class, 'emergency_id', 'id');
    }

    public static function getReporterWorkplaceNameByType(string $type): string
    {
        if ($type === Firehouse::class) {
            return 'ДПРЧ';
        } else if ($type === Detachment::class) {
            return 'ДПРЗ';
        } else if ($type === Headquarter::class) {
            return 'ГУ';
        } else {
            return '';
        }
    }

}
