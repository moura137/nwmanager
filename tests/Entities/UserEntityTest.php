<?php

namespace Tests\Entities;

use Tests\TestCase;
use Mockery as m;
use NwManager\Entities\User;

class UserEntityTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $user = new User;

        $this->assertInstanceOf('NwManager\Entities\AbstractEntity', $user);
        $this->assertInstanceOf('Illuminate\Contracts\Auth\Authenticatable', $user);
        $this->assertInstanceOf('Illuminate\Contracts\Auth\CanResetPassword', $user);
        
        $this->assertTraitExists('Illuminate\Auth\Authenticatable', $user);
        $this->assertTraitExists('Illuminate\Auth\Passwords\CanResetPassword', $user);

        $fillable = ['name', 'email', 'password'];
        $this->assertAttributeEquals($fillable, 'fillable', $user);

        $fillable = ['password', 'remember_token'];
        $this->assertAttributeEquals($fillable, 'hidden', $user);
    }

    public function testOwnerProjects()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\HasMany');

        $user = m::mock('NwManager\Entities\User[hasMany]');
        $user->shouldReceive('hasMany')->once()->with('NwManager\Entities\Project', 'owner_id')->andReturn($relation);

        $this->assertEquals($relation, $user->owner_projects());
    }

    public function testMemberProjects()
    {
        $relation = m::mock('Illuminate\Database\Eloquent\Relations\BelongsToMany');

        $user = m::mock('NwManager\Entities\User[belongsToMany]');
        $user->shouldReceive('belongsToMany')
            ->once()
            ->with('NwManager\Entities\Project', 'project_members')
            ->andReturn($relation);

        $this->assertEquals($relation, $user->member_projects());
    }

    public function testSetPassword()
    {
        $senhaCript = bcrypt('12345');

        $hash = m::mock('Illuminate\Hashing\BcryptHasher');
        $hash->shouldReceive('make')->once()->with('12345', [])->andReturn($senhaCript);
        $this->app->instance('hash', $hash);
        
        $user = new \NwManager\Entities\User;
        $user->password = '12345';
        $user->password = '';

        $this->assertAttributeEquals(['password' => $senhaCript], 'attributes', $user);
        $this->assertEquals($senhaCript, $user->password);
    }
}

