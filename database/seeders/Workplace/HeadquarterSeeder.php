<?php

namespace Database\Seeders\Workplace;

use App\Models\Workplace\Headquarter;
use Illuminate\Database\Seeder;

class HeadquarterSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            ['oblast' => Headquarter::OBLAST_KYIVSKA],
            ['oblast' => Headquarter::OBLAST_DNEPROPETROVSKA],
        ];

        foreach ($data as $item) {
            Headquarter::create($item);
        }
    }
}
