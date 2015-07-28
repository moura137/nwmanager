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

        Entities\User::truncate();
        factory(Entities\User::class, 5)->create();
        $users = Entities\User::all()->lists('id')->toArray();

        Entities\Client::truncate();
        factory(Entities\Client::class, 5)->create();
        $clients = Entities\Client::all()->lists('id')->toArray();
        
        Entities\Project::truncate();
        factory(Entities\Project::class, 5)
            ->make()
            ->each(function($project) use ($faker, $users, $clients) {
                $project->owner_id = $faker->randomElement($users);
                $project->client_id = $faker->randomElement($clients);
                $project->save();
            });

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Model::reguard();
    }
}
