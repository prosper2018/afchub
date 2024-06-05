<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'service_name' => 'Service 1',
                'description' => 'Description of Service 1',
                'company_id' => 1,
            ],
            [
                'service_name' => 'Service 2',
                'description' => 'Description of Service 2',
                'company_id' => 1,
            ],
            [
                'service_name' => 'Service 3',
                'description' => 'Description of Service 3',
                'company_id' => 1,
            ],
        ];

        DB::table('services')->insert($services);
    }
}
