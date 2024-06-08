<?php

namespace App\Models\Emergency;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyType extends Model
{
    use softDeletes;

    public const TYPE_FIRE = 'Пожежа';
    public const TYPE_TRAINING = 'Навчання';
    public const TYPE_DROWNING = 'Потоплення';
    public const TYPE_TYPHOON = 'Тайфун';
    public const TYPE_STORM = 'Буря';
    public const TYPE_HURRICANE = 'Ураган';
    public const TYPE_SEARCH_WORKS = 'Пошукові роботи';
    public const TYPE_POLICE_ASSISTANCE = 'Сприяння поліції';
    public const TYPE_TERRORISTIC_ATTACK = 'Терорестичний акт';
    public const TYPE_MINE_CLEARANCE = 'Розмінування';
    public const TYPE_POPULATION_MOVEMENT = 'Переміщення населення';

    protected $fillable = [
        'name',
        'created_by',
    ];
}
