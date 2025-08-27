<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Page;
use App\Models\Survey;
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
        $this->call([
            AdminUserSeeder::class,
            PegawaiSeeder::class,
            AgendaSeeder::class,
            PageSeeder::class,
            SurveySeeder::class,
        ]);
    }
}
