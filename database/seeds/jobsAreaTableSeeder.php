<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class jobsAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table ('jobs_area')->insert ([
            'name_job' => 'Ingeniero civil'
        ]);
        DB::table ('jobs_area')->insert ([
            'name_job' => 'Arquitecto'
        ]);
        DB::table ('jobs_area')->insert ([
            'name_job' => 'Obrero'
        ]);
        DB::table ('jobs_area')->insert ([
            'name_job' => 'Ingeniero de sistemas'
        ]);
        DB::table ('jobs_area')->insert ([
            'name_job' => 'Ingeniero agronomo'
        ]);
    }
}
