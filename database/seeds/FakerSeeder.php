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
        $this->call(FakerOAuth2Seeder::class);

        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $faker = app('Faker\Generator');

        // Users
        Entities\User::truncate();
        factory(Entities\User::class)->create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => '123456',
            'remember_token' => str_random(10),
        ]);
        factory(Entities\User::class, 5)->create();

        // Clients
        Entities\Client::truncate();
        factory(Entities\Client::class, 5)->create();

        // Projects
        Entities\Project::truncate();
        factory(Entities\Project::class, 10)->create();

        // Projects Member Aleatorios
        $projects = Entities\Project::all();
        foreach ($projects as $project) {
            for($x=0;$x<rand(1,5);$x++) $rand[] = rand(1,6);
            $project->members()->sync($rand);
        }

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