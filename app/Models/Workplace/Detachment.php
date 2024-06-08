<?php

namespace App\Models\Workplace;

use App\Models\Emergency\Emergency;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Detachment extends Model
{
    use softDeletes;

    protected $fillable = [
        'headquarter_id',
        'number',
    ];

    public $timestamps = false;

    public function headquarter(): BelongsTo
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function employees(): MorphMany
    {
        return $this->morphMany(Employee::class, 'workplace');
    }

    public function emergencies(): MorphMany
    {
        return $this->morphMany(Emergency::class, 'reporterWorkplace');
    }

    public static function getIdByOblastAndNumber(string $oblast, int $number): ?int
    {
        return Cache::rememberForever('detachments:' . $oblast . '-' . $number, function () use ($oblast, $number) {
            $headquarterId = Headquarter::getIdByOblast($oblast);

            $detachment = self::query()
                ->select('id')
                ->where('headquarter_id', $headquarterId)
                ->where('number', $number)
                ->first();

            return optional($detachment)->id;
        });
    }
}
