<?php

namespace Tests\Repositories\Eloquent;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Eloquent\UserEloquentRepository;

class UserRepositoryTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $repo = new UserEloquentRepository($this->app);

        $this->assertInstanceOf('NwManager\Repositories\Contracts\UserRepository', $repo);
        $this->assertInstanceOf('NwManager\Repositories\Eloquent\AbstractEloquentRepository', $repo);
        $this->assertInstanceOf('Prettus\Repository\Eloquent\BaseRepository', $repo);
        
        $fieldSearchable = ['name' => 'like', 'username' => 'like'];
        $this->assertAttributeEquals($fieldSearchable, 'fieldSearchable', $repo);

        $this->assertEquals('NwManager\Entities\User', $repo->model());
    }
}

