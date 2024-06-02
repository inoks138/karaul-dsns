<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Collection;

class VehicleService
{
    public function getVehicles(array $data): Collection
    {
        return Vehicle::query()
            ->with(['model'])
            ->when(!empty($data['vehicle_type_id']), function ($query) use ($data) {
                $query->whereHas('model', function ($query) use ($data) {
                    $query->whereIn('vehicle_type_id', $data['vehicle_type_id']);
                });
            })
            ->when(!empty($data['firehouse_id']), function ($query) use ($data) {
                $query->where('firehouse_id', $data['firehouse_id']);
            })
            ->when(!empty($data['search']), function ($query) use ($data) {
                $query->whereHas('model', function ($query) use ($data) {
                    $query->whereLike('name', $data['search'])
                        ->orWhereLike('license_plate', $data['search']);
                });
            })
            ->get();
    }
}
