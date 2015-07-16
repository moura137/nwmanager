<?php

use Illuminate\Database\Seeder;
use NwManager\Client;

class FakerClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::truncate();
        factory(Client::class, 5)->create();
    }
}
