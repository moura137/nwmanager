<?php

namespace Tests\OAuth;

use Tests\TestCase;
use NwManager\OAuth\Verifier;
use Illuminate\Support\Facades\Auth;

class VerifierTest extends TestCase
{
    public function testVerifySucess()
    {
        $user = new \stdClass;
        $user->id = 1;

        Auth::shouldReceive('once')
            ->once()
            ->with(['username' => 'user@email.com', 'password' => '1234'])
            ->andReturn(true);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $verifier = new Verifier;
        $this->assertEquals(1, $verifier->verify('user@email.com', '1234'));
    }
}