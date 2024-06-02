<?php

namespace App\Services\Employee;

use App\Helpers\SqlHelper;
use App\Models\Employee\Employee;
use App\Models\Workplace\Firehouse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function getEmployees(array $data): Collection
    {
        $employeeFullNameSql = SqlHelper::getEmployeeFullNameSql();

        return Employee::query()
            ->select([
                'employees.*',
                DB::raw("($employeeFullNameSql) as full_name"),
            ])
            ->when(!empty($data['position_id']), function ($query) use ($data) {
                $query->whereIn('position_id', $data['position_id']);
            })
            ->when(!empty($data['firehouse_id']), function ($query) use ($data) {
                $query->where('workplace_id', $data['firehouse_id'])
                    ->where('workplace_type', Firehouse::class);
            })
            ->when(!empty($data['search']), function ($query) use ($data) {
                $query->havingRaw('full_name LIKE "%' . $data['search'] . '%"');
            })
            ->get();
    }
}
