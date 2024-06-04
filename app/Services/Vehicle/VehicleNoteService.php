<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle\Vehicle;
use App\Models\Vehicle\VehicleNoteState;
use Illuminate\Database\Eloquent\Collection;

class VehicleNoteService
{
    public function getStates(): Collection
    {
        return VehicleNoteState::all();
    }
}
