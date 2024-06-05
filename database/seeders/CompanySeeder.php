<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'company_name' => 'Tech Innovators Inc.',
                'company_email' => 'info@techinnovators.com',
                'services' => 'Software Development, IT Consulting, Cloud Services',
                'country' => 'USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'Global Solutions Ltd.',
                'company_email' => 'contact@globalsolutions.com',
                'services' => 'Business Consulting, Market Analysis, Strategic Planning',
                'country' => 'UK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'Creative Minds Agency',
                'company_email' => 'hello@creativeminds.com',
                'services' => 'Digital Marketing, Content Creation, Branding',
                'country' => 'Canada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
