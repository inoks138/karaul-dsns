<?php

namespace App\Models\Workplace;

use App\Models\Emergency\Emergency;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Headquarter extends Model
{
    use softDeletes;

    public const OBLAST_KYIVSKA = 'Kyivska';
    public const OBLAST_DNEPROPETROVSKA = 'Dnepropetrovska';

    protected $fillable = [
        'oblast',
    ];

    public $timestamps = false;

    public function employees(): MorphMany
    {
        return $this->morphMany(Employee::class, 'workplace');
    }

    public function emergencies(): MorphMany
    {
        return $this->morphMany(Emergency::class, 'reporterWorkplace');
    }

    public static function getIdByOblast(string $oblast): ?int
    {
        return Cache::rememberForever('headquarters:' . $oblast, function () use ($oblast) {
            $headquarter = self::query()
                ->select('id')
                ->where('oblast', $oblast)
                ->first();

            return optional($headquarter)->id;
        });
    }
}
