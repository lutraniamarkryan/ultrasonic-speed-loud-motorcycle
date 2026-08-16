<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Violation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ViolationSeeder extends Seeder
{
    public function run()
    {
        // Prevent foreign key / truncation bottlenecks
        Schema::disableForeignKeyConstraints();
        Violation::truncate();
        Schema::enableForeignKeyConstraints();

        // Target pooling of license plates for repeat offenders tracking
        $plates = [
            'NRE-4921', 'NRE-4921', 'NRE-4921', // Repeat Offender 1 (3 triggers)
            'ABC-1234', 'ABC-1234',             // Repeat Offender 2 (2 triggers)
            'XYZ-9876', 'XYZ-9876', 'XYZ-9876', // Repeat Offender 3 (3 triggers)
            'GHI-7603', 'JKL-2345', 'MNO-6789', 
            'PQR-1122', 'STU-4455', 'VWX-8899'
        ];

        $violationTypes = ['Overspeeding', 'Loud Pipe', 'Both'];
        $locations = ['Bactad East Station', 'Poblacion Crossroads', 'McArthur Highway Node'];

        // Generate 60 diverse distributed mock violations
        for ($i = 0; $i < 60; $i++) {
            $type = $violationTypes[array_rand($violationTypes)];
            
            $speed = null;
            $noise = null;

            // Enforce realistic hardware logging constraints based on type conditions
            if ($type === 'Overspeeding') {
                $speed = rand(65, 120);   // Violating speed limits
                $noise = null;            // Normal or unrecorded audio baseline
            } elseif ($type === 'Loud Pipe') {
                $speed = null;            // Normal or unrecorded speed metric
                $noise = rand(92, 115);   // Excessive muffler decibels
            } elseif ($type === 'Both') {
                $speed = rand(65, 120);   // Over-speeding
                $noise = rand(92, 115);   // Over-decibel muffler limits
            }

            // Distribute records smoothly over the past 30 days and randomize layout hours
            $randomDate = Carbon::now()
                ->subDays(rand(0, 30))
                ->setHour(rand(0, 23))
                ->setMinute(rand(0, 59))
                ->setSecond(rand(0, 59));

            Violation::create([
                'plate_number'   => $plates[array_rand($plates)],
                'violation_type' => $type,
                'recorded_speed' => $speed,
                'decibel_level'  => $noise,
                'location'       => 'Binalonan, Pangasinan',
                'date'           => $randomDate,
                'status'         => rand(0, 1) ? 'Pending' : 'Resolved',
                'created_at'     => $randomDate,
                'updated_at'     => $randomDate,
            ]);
        }
    }
}