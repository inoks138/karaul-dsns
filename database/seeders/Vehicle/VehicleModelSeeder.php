<?php

namespace Database\Seeders\Vehicle;

use App\Models\Role;
use App\Models\User;
use App\Models\Vehicle\VehicleModel;
use App\Models\Vehicle\VehicleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VehicleModelSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $typeGeneralId = VehicleType::getGeneralId();
        $typeLadderId = VehicleType::getLadderId();
        $typeSupportId = VehicleType::getSupportId();

        $generalVehicleModelNames = [
            'АЦ-2-30 (NQR90)-537IS2',
            'АЦ-2,5-30 (NQR90)-537IS',
            'АЦ-3,2-40 (TGM 15.250)-163М',
            'АЦ-3,0-40 (ЕХ8)-477Н',
            'АЦ-18 (LPT 613)-411',
            'АЦ-2,0-40 (HD65)-477',
            'АЦ-3,2-40 (TGM 15.250)-163М',
            'АЦ-4-60 (150Е28W)-525I',
            'АЦ-5-50 (1833)-442F',
            'АЦП EN 1846-S-1-6-5000-10/3000-2',
            'АЦ-4-60 (530927)-515М',
            'АЦ-60 (TGM 15.250)-164',
            'АЦ-40 (LPT 1116)-484',
            'АЦ-8-50 (3542)-508F',
            'АЦ-8-50 (CM6C7)-518D',
            'АЦ-8-50 (AD380T41W)-530I',
            'АЦ-8-50 (TGS 26.360)-530МN',
            'АЦ-8-50 (6511)-530K',
            'АЦ-8-60 (TGS 33.360)-526М',
            'АЦ-7-40 (5401Н2)-155.01',
            'АЦ-40 (43118)-269',
            'АЦ-60 (65111)-264.01',
            'АЦ-60 (65111)-264.02',
            'АЦ-40 (53228)-264',
            'АЦ-40 (65053)-261',
            'АЦ-7,0-60 (43118)-254.02',
            'АЦ-40 (43118)-235.05',
            'АЦ-40 (43118)-235',
        ];
        $ladderVehicleModelNames = [
            'АД-30 (131) Л21',
            'АД-30 (131) ПМ 506',
            'АД -50 (269-32АР) Магірус',
        ];
        $supportVehicleModelNames = [
            'АСА-20 (43114)-182',
            'AП – 5 (53215)-196',
            'АП-5 (65115)-221.01',
            'ПНС-110 (5313)-131А.02',
            'ПНС–110 (43114)–140',
        ];

        foreach ($generalVehicleModelNames as $modelName) {
            VehicleModel::create([
                'name' => $modelName,
                'vehicle_type_id' => $typeGeneralId,
                'number_of_passengers' => 5,
            ]);
        }

        foreach ($ladderVehicleModelNames as $modelName) {
            VehicleModel::create([
                'name' => $modelName,
                'vehicle_type_id' => $typeLadderId,
                'number_of_passengers' => 5,
            ]);
        }

        foreach ($supportVehicleModelNames as $modelName) {
            VehicleModel::create([
                'name' => $modelName,
                'vehicle_type_id' => $typeSupportId,
                'number_of_passengers' => 1,
            ]);
        }
    }
}
