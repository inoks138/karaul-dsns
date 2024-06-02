<?php

namespace Database\Seeders\Workplace;

use App\Models\Workplace\Detachment;
use App\Models\Workplace\Firehouse;
use App\Models\Workplace\Headquarter;
use Illuminate\Database\Seeder;

class FirehouseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $kyivFirstDetachmentId = Detachment::getIdByOblastAndNumber(Headquarter::OBLAST_KYIVSKA, 1);
        $kyivSecondDetachmentId = Detachment::getIdByOblastAndNumber(Headquarter::OBLAST_KYIVSKA, 2);
        $kyivThirdDetachmentId = Detachment::getIdByOblastAndNumber(Headquarter::OBLAST_KYIVSKA, 3);
        $kyivFourthDetachmentId = Detachment::getIdByOblastAndNumber(Headquarter::OBLAST_KYIVSKA, 4);
        $dnepropetrovskFirstDetachmentId = Detachment::getIdByOblastAndNumber(Headquarter::OBLAST_DNEPROPETROVSKA, 1);
        $dnepropetrovsSecondDetachmentId = Detachment::getIdByOblastAndNumber(Headquarter::OBLAST_DNEPROPETROVSKA, 2);
        $dnepropetrovskThirdDetachmentId = Detachment::getIdByOblastAndNumber(Headquarter::OBLAST_DNEPROPETROVSKA, 3);

        $kyivFirehouseData = [
            [
                'detachment_id' => $kyivFirstDetachmentId,
                'number' => 1,
                'address' => 'Address 1',
            ],
            [
                'detachment_id' => $kyivFirstDetachmentId,
                'number' => 2,
                'address' => 'Address 2',
            ],
            [
                'detachment_id' => $kyivFirstDetachmentId,
                'number' => 3,
                'address' => 'Address 3',
            ],
            [
                'detachment_id' => $kyivSecondDetachmentId,
                'number' => 4,
                'address' => 'Address 4',
            ],
            [
                'detachment_id' => $kyivSecondDetachmentId,
                'number' => 5,
                'address' => 'Address 5',
            ],
            [
                'detachment_id' => $kyivThirdDetachmentId,
                'number' => 6,
                'address' => 'Address 6',
            ],
            [
                'detachment_id' => $kyivFourthDetachmentId,
                'number' => 7,
                'address' => 'Address 7',
            ],
        ];

        $dnepropetrovskFirehouseData = [
            [
                'detachment_id' => $dnepropetrovskFirstDetachmentId,
                'number' => 1,
                'address' => 'Address 1',
            ],
            [
                'detachment_id' => $dnepropetrovskFirstDetachmentId,
                'number' => 2,
                'address' => 'Address 2',
            ],
            [
                'detachment_id' => $dnepropetrovskFirstDetachmentId,
                'number' => 3,
                'address' => 'Address 3',
            ],
            [
                'detachment_id' => $dnepropetrovskFirstDetachmentId,
                'number' => 4,
                'address' => 'Address 4',
            ],
            [
                'detachment_id' => $dnepropetrovsSecondDetachmentId,
                'number' => 5,
                'address' => 'Address 5',
            ],
            [
                'detachment_id' => $dnepropetrovsSecondDetachmentId,
                'number' => 6,
                'address' => 'Address 6',
            ],
            [
                'detachment_id' => $dnepropetrovskThirdDetachmentId,
                'number' => 7,
                'address' => 'Address 7',
            ],
        ];

        $data = array_merge(
            $kyivFirehouseData,
            $dnepropetrovskFirehouseData,
        );

        foreach ($data as $item) {
            Firehouse::create($item);
        }
    }
}
