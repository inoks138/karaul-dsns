<?php

namespace App\Services\Guard;

use App\Models\Guard\Guard;
use App\Models\Guard\Unit;

class GuardService
{
    public function startGuard(array $data): Guard
    {
        $chief = auth()->user()->employee;

        $guard = Guard::create([
            'firehouse_id' => $chief->workplace_id,
            'start_time' => $data['start_time'],
            'end_time' => null,
            'chief_id' => $chief->id,
            'dispatcher_id' => $data['dispatcher_id'],
        ]);

        $prevGuard = $guard->getPrevious();

        if ($prevGuard) {
            $prevGuard->update([
                'end_time' => $guard->start_time,
            ]);
            //@todo: add $data['prev_guard_comment'] to duty order
        }

        return $guard;
    }

    public function getCurrentGuard(): ?Guard
    {
        $userEmployee = auth()->user()->employee;

        return Guard::query()
            ->where('firehouse_id', $userEmployee->workplace_id)
            ->where('start_time', '<', now())
            ->whereNull('end_time')
            ->orderBy('start_time', 'desc')
            ->first();
    }

    public function createUnitsForGuard(array $data, Guard $guard): void
    {
        $unitsData = $data['units'];

        foreach ($unitsData as $unitData) {
            $unit = Unit::create([
                'guard_id' => $guard->id,
                'commander_id' => $unitData['commander_id'],
                'driver_id' => $unitData['driver_id'],
                'vehicle_id' => $unitData['vehicle_id'],
            ]);

            $unit->firefighters()->sync($unitData['firefighters']);
        }
    }
}
