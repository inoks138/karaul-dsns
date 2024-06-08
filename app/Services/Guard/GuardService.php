<?php

namespace App\Services\Guard;

use App\Helpers\SqlHelper;
use App\Models\Employee\Employee;
use App\Models\Guard\Guard;
use App\Models\Guard\GuardInternalServiceType;
use App\Models\Guard\Unit;
use App\Models\Vehicle\VehicleNote;
use App\Models\Workplace\Firehouse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
                'number' => $unitData['number'],
                'commander_id' => $unitData['commander_id'],
                'driver_id' => $unitData['driver_id'],
                'vehicle_id' => $unitData['vehicle_id'],
            ]);

            $unit->firefighters()->sync($unitData['firefighters']);
        }
    }

    public function createVehicleNotesForGuard(array $data, Guard $guard): void
    {
        $vehicleNotesData = $data['vehicles'];

        foreach ($vehicleNotesData as $vehicleNoteData) {
            VehicleNote::create([
                'vehicle_id' => $vehicleNoteData['vehicle_id'],
                'guard_id' => $guard->id,
                'state_id' => $vehicleNoteData['state_id'],
                'state_comment' => $vehicleNoteData['state_comment'] ?? null,
                'fuel' => $vehicleNoteData['fuel'],
                'fire_extinguishing_equipment' => $vehicleNoteData['fire_extinguishing_equipment'],
            ]);
        }
    }

    public function getInternalServiceTypes(): Collection
    {
        return GuardInternalServiceType::all();
    }

    public function getEndGuardData(Guard $guard): array
    {
        $data = [];

        $employeeFullNameSql = SqlHelper::getEmployeeFullNameSql();

        $guard->load([
            'chief' => function ($query) use ($employeeFullNameSql) {
                $query->select([
                    'employees.*',
                    DB::raw("($employeeFullNameSql) as full_name")
                ]);
            },
            'dispatcher' => function ($query) use ($employeeFullNameSql) {
                $query->select([
                    'employees.*',
                    DB::raw("($employeeFullNameSql) as full_name")
                ]);
            },
        ]);

        $employeesCount = Employee::query()
            ->where('workplace_id', $guard->firehouse_id)
            ->where('workplace_type', Firehouse::class)
            ->count();

        $operationalCalculationEmployeesCount = Unit::query()
            ->select('id')
            ->withCount('firefighters')
            ->where('guard_id', $guard->id)
            ->get()
            ->reduce(function (?int $carry, Unit $unit) {
                return $carry + $unit->firefighters_count;
            });

        $operationalCalculationEmployeesCount += Unit::where('guard_id', $guard->id)->count() * 2;

        $data['guard'] = $guard;
        $data['employees_count'] = $employeesCount;
        $data['operational_calculation_employees_count'] = $operationalCalculationEmployeesCount;

        return $data;
    }

    public function endGuard(array $data, Guard $guard): void
    {

    }

    public function getUnits(): Collection
    {
        $currentGuard = $this->getCurrentGuard();

        return Unit::query()
            ->where('guard_id', $currentGuard->id)
            ->with([
                'activeEmergencyLiquidation',
                'activeEmergencyLiquidation.vehicle',
                'activeEmergencyLiquidation.vehicle.model',
                'activeEmergencyLiquidation.vehicle.model.type',
                'activeEmergencyLiquidation.emergency',
                'commander',
            ])
            ->get();
    }
}
