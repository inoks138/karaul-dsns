<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class EmployeePosition extends Model
{
    use softDeletes;

    public const POSITION_GUARD_CHIEF = 'guard_chief';
    public const POSITION_DISPATCHER = 'dispatcher';
    public const POSITION_FIREFIGHTER = 'firefighter';
    public const POSITION_SECRETARY = 'secretary';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public static function getGuardChiefId(): int
    {
        return Cache::rememberForever('employee_positions:guard_chief', function () {
            return self::where('name', self::POSITION_GUARD_CHIEF)->first()->id;
        });
    }

    public static function getDispatcherId(): int
    {
        return Cache::rememberForever('employee_positions:dispatcher', function () {
            return self::where('name', self::POSITION_DISPATCHER)->first()->id;
        });
    }

    public static function getSecretaryId(): int
    {
        return Cache::rememberForever('employee_positions:secretary', function () {
            return self::where('name', self::POSITION_SECRETARY)->first()->id;
        });
    }

    public static function getFirefighterId(): int
    {
        return Cache::rememberForever('employee_positions:firefighter', function () {
            return self::where('name', self::POSITION_FIREFIGHTER)->first()->id;
        });
    }
}
