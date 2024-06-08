<?php

namespace App\Services\Workplace;

use App\Models\Workplace\Firehouse;
use Illuminate\Database\Eloquent\Collection;

class WorkplaceService
{
    public function getFirehouses(): Collection
    {
        return Firehouse::query()
            ->where('detachment_id', auth()->user()->employee->workplace_id)
            ->get();
    }
}
