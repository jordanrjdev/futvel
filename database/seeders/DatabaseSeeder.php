<?php

namespace Database\Seeders;

use App\Models\League;
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
        League::factory()->create();
        // \App\Models\User::factory(10)->create();
    }
}
