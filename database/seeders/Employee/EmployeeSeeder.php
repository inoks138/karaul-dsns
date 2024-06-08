<?php

namespace Database\Seeders\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeePosition;
use App\Models\Workplace\Detachment;
use App\Models\Workplace\Firehouse;
use App\Models\Workplace\Headquarter;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $headquarterId = Headquarter::getIdByOblast(Headquarter::OBLAST_KYIVSKA);
        $detachmentId = Detachment::query()
            ->where('headquarter_id', $headquarterId)
            ->where('number', 1)
            ->first()
            ->id;
        $firehouseId = Firehouse::query()
            ->where('detachment_id', $detachmentId)
            ->where('number', 1)
            ->first()
            ->id;

        $guardChiefs = [
            [
                'first_name' => 'Xyz-1',
                'last_name' => 'Chief-1',
                'patronymic' => 'A',
                'workplace_id' => $firehouseId,
                'workplace_type' => Firehouse::class,
                'position_id' => EmployeePosition::getGuardChiefId(),
            ],
            [
                'first_name' => 'Xyz-2',
                'last_name' => 'Chief-2',
                'patronymic' => 'A',
                'workplace_id' => $firehouseId,
                'workplace_type' => Firehouse::class,
                'position_id' => EmployeePosition::getGuardChiefId(),
            ],
            [
                'first_name' => 'Xyz-3',
                'last_name' => 'Chief-3',
                'patronymic' => 'A',
                'workplace_id' => $firehouseId,
                'workplace_type' => Firehouse::class,
                'position_id' => EmployeePosition::getGuardChiefId(),
            ],
            [
                'first_name' => 'Xyz-4',
                'last_name' => 'Chief-4',
                'patronymic' => 'A',
                'workplace_id' => $firehouseId,
                'workplace_type' => Firehouse::class,
                'position_id' => EmployeePosition::getGuardChiefId(),
            ],
        ];
        $dispatchers = [
            [
                'first_name' => 'Xyz-5',
                'last_name' => 'Dispatcher-1',
                'patronymic' => 'A',
                'workplace_id' => $firehouseId,
                'workplace_type' => Firehouse::class,
                'position_id' => EmployeePosition::getDispatcherId(),
            ],
            [
                'first_name' => 'Xyz-6',
                'last_name' => 'Dispatcher-2',
                'patronymic' => 'A',
                'workplace_id' => $firehouseId,
                'workplace_type' => Firehouse::class,
                'position_id' => EmployeePosition::getDispatcherId(),
            ],
            [
                'first_name' => 'Xyz-7',
                'last_name' => 'Dispatcher-3',
                'patronymic' => 'A',
                'workplace_id' => $firehouseId,
                'workplace_type' => Firehouse::class,
                'position_id' => EmployeePosition::getDispatcherId(),
            ],
            [
                'first_name' => 'Xyz-8',
                'last_name' => 'Dispatcher-4',
                'patronymic' => 'A',
                'workplace_id' => $firehouseId,
                'workplace_type' => Firehouse::class,
                'position_id' => EmployeePosition::getDispatcherId(),
            ],
            [
                'first_name' => 'Xyz-asd',
                'last_name' => 'Dispatcher-asd',
                'patronymic' => 'A',
                'workplace_id' => 1,
                'workplace_type' => Detachment::class,
                'position_id' => EmployeePosition::getDispatcherId(),
            ],
        ];
        $secretaries = [
            [
                'first_name' => 'Xyz-9',
                'last_name' => 'Secretary-1',
                'patronymic' => 'A',
                'workplace_id' => $detachmentId,
                'workplace_type' => Detachment::class,
                'position_id' => EmployeePosition::getSecretaryId(),
            ],
            [
                'first_name' => 'Xyz-10',
                'last_name' => 'Secretary-2',
                'patronymic' => 'A',
                'workplace_id' => $headquarterId,
                'workplace_type' => Headquarter::class,
                'position_id' => EmployeePosition::getSecretaryId(),
            ],
        ];

        $data = array_merge(
            $guardChiefs,
            $dispatchers,
            $secretaries
        );

         foreach ($data as $item) {
             Employee::create($item);
         }

        Employee::factory()->count(3)->unitCommander()->create();
        Employee::factory()->count(3)->unitDriver()->create();
        Employee::factory()->count(18)->create();
    }
}
