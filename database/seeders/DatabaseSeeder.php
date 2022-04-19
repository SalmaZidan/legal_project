<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\IssueType::create([
            'name_ar' => 'type ar',
            'name_en' => 'type en',
        ]);
        \App\Models\Court::create([
            'name_ar' => 'courts ar name',
            'name_en' => 'courts en name',
            'address_ar' => 'address ar test',
            'address_en' => 'address en test',
            'governorate_id' => '1',
            'link' => 'link test',
        ]);
        $this->call([
            UserSeeder::class,
            GovernorateSeeder::class,
        ]);

    }
}
