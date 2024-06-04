<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class VehicleNoteState extends Model
{
    public const STATE_OPERATIONAL_CALCULATION = 'Оперативний розрахунок';
    public const STATE_RESERVE = 'Резерв';
    public const STATE_REPAIR = 'Ремонт';
    public const STATE_CONSERVATION = 'Консервація';
    public const STATE_OTHER = 'Інше';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;
}
