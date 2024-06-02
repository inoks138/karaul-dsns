<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use softDeletes, hasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'workplace_id',
        'workplace_type',
        'position_id',
        'can_be_unit_driver',
        'can_be_unit_commander',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(EmployeePosition::class);
    }

    public function workplace(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->whereRaw("CONCAT(employees.first_name, ' ', employees.last_name, ' ', employees.patronymic) LIKE '%$search%'");
    }
}
