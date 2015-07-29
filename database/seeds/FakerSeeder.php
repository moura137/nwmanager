<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use NwManager\Entities;

class FakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        $faker = app('Faker\Generator');

        // Users
        Entities\User::truncate();
        factory(Entities\User::class, 5)->create();

        // Clients
        Entities\Client::truncate();
        factory(Entities\Client::class, 5)->create();
        
        // Projects
        Entities\Project::truncate();
        factory(Entities\Project::class, 10)->create();

        // Projects Note
        Entities\ProjectNote::truncate();
        factory(Entities\ProjectNote::class, 50)->create();

        // Projects Task
        Entities\ProjectTask::truncate();
        factory(Entities\ProjectTask::class, 50)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Model::reguard();
    }
}
