<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    use softDeletes;

    public const ROLE_GUARD_CHIEF = 'guard_chief';
    public const ROLE_DISPATCHER = 'dispatcher';
    public const ROLE_SECRETARY = 'secretary';

//    public const ROLE_ADMIN = 'admin';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public static function getGuardChiefId(): int
    {
        return Cache::rememberForever('roles:guard_chief', function () {
            return self::where('name', self::ROLE_GUARD_CHIEF)->first()->id;
        });
    }

    public static function getDispatcherId(): int
    {
        return Cache::rememberForever('roles:dispatcher', function () {
            return self::where('name', self::ROLE_DISPATCHER)->first()->id;
        });
    }

    public static function getSecretaryId(): int
    {
        return Cache::rememberForever('roles:secretary', function () {
            return self::where('name', self::ROLE_SECRETARY)->first()->id;
        });
    }
}
