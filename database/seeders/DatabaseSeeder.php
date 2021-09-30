<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Team;
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
        $team = Team::factory()->create();
        $team->leagues()->attach(League::factory(10)->create()->pluck('id')->toArray());
        // \App\Models\User::factory(10)->create();
    }
}
