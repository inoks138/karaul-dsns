<?php

namespace App\Models\Guard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardInternalServiceType extends Model
{
    public const TYPE_GATE_CHECK = 'Пропускний контроль';
    public const TYPE_TERRITORY_PATROL = 'Патрулювання теріторрії';
    public const TYPE_SAFETY_CONTROL = 'Інструктаж техніки безпеки';
    public const TYPE_EQUIPMENT_USE_CONTROL = 'Інструктаж з використання обладняння';

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;
}
