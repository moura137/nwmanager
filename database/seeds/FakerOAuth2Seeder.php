<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FakerOAuth2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datetime = \Carbon\Carbon::now();

        // Client
        $clientId = 'ANGULAR_APP';
        $client = DB::table('oauth_clients')->where('id', $clientId)->first();
        if ($client) {
            $secret = $client->secret;

        } else {
            DB::table('oauth_clients')->insert([
                'id' => $clientId,
                'name' => 'Autentication for Angular',
                'secret' => $secret = str_random(20),
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);
        }
        $this->command->info("APP_ID: {$clientId}");
        $this->command->info("SECRET: {$secret}");

        $constants = [
            'BASE_PATH' => 'http://localhost:8000',
            'API_URL' => 'http://localhost:8000',
            'AUTH_SECURE' => false,
            'BROADCAST_DRIVER' => config('broadcasting.default'),
            'PUSHER_API_KEY' => config('broadcasting.connections.pusher.key'),
            'FANOUT_REALM_ID' => config('broadcasting.connections.fanout.realm_id'),
        ];

        $path = base_path('env-config.json');
        if (File::exists($path)) {
            $atual = (array) @json_decode(File::get($path));
            $constants = array_merge($constants, $atual);
        }

        $constants['CLIENT_ID'] = $clientId;
        $constants['CLIENT_SECRET'] = $secret;

        File::put(base_path('env-config.json'), str_replace('\\', '', json_encode($constants)));

        // Grant
        $grantId = 'password';
        $grant = DB::table('oauth_grants')->where('id', $grantId)->first();
        if (!$grant) {
            DB::table('oauth_grants')->insert([
                'id' => $grantId,
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);
        }

        // Client to Grant
        $clientGrant = DB::table('oauth_client_grants')
            ->where('client_id', $clientId)
            ->where('grant_id', $grantId)
            ->first();

        if (!$clientGrant) {
            DB::table('oauth_client_grants')->insert([
                'client_id' => $clientId,
                'grant_id' => $grantId,
                'created_at' => $datetime,
                'updated_at' => $datetime,
            ]);
        }
    }
}
