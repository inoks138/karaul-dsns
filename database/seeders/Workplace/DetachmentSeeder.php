<?php

namespace Database\Seeders\Workplace;

use App\Models\Workplace\Detachment;
use App\Models\Workplace\Headquarter;
use Illuminate\Database\Seeder;

class DetachmentSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $kyivHeadquarterId = Headquarter::getIdByOblast(Headquarter::OBLAST_KYIVSKA);
        $dnepropetrovskHeadquarterId = Headquarter::getIdByOblast(Headquarter::OBLAST_DNEPROPETROVSKA);

        $data = [
            ['headquarter_id' => $kyivHeadquarterId, 'number' => 1],
            ['headquarter_id' => $kyivHeadquarterId, 'number' => 2],
            ['headquarter_id' => $kyivHeadquarterId, 'number' => 3],
            ['headquarter_id' => $kyivHeadquarterId, 'number' => 4],
            ['headquarter_id' => $dnepropetrovskHeadquarterId, 'number' => 1],
            ['headquarter_id' => $dnepropetrovskHeadquarterId, 'number' => 2],
            ['headquarter_id' => $dnepropetrovskHeadquarterId, 'number' => 3],
        ];

        foreach ($data as $item) {
            Detachment::create($item);
        }
    }
}
