<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class VehicleType extends Model
{
    use softDeletes;

    public const TYPE_GENERAL = 'general';
    public const TYPE_LADDER = 'ladder';
    public const TYPE_SUPPORT = 'support';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public static function getGeneralId(): int
    {
        return Cache::rememberForever('vehicle_types:general', function () {
            return self::where('name', self::TYPE_GENERAL)->first()->id;
        });
    }

    public static function getLadderId(): int
    {
        return Cache::rememberForever('vehicle_types:ladder', function () {
            return self::where('name', self::TYPE_LADDER)->first()->id;
        });
    }

    public static function getSupportId(): int
    {
        return Cache::rememberForever('vehicle_types:support', function () {
            return self::where('name', self::TYPE_SUPPORT)->first()->id;
        });
    }
}
