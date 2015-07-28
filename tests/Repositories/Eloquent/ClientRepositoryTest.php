<?php

namespace Tests\Repositories\Eloquent;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Eloquent\ClientEloquentRepository;

class ClientRepositoryTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $repo = new ClientEloquentRepository($this->app);

        $this->assertInstanceOf('NwManager\Repositories\Contracts\ClientRepository', $repo);
        $this->assertInstanceOf('NwManager\Repositories\Eloquent\AbstractEloquentRepository', $repo);
        $this->assertInstanceOf('Prettus\Repository\Eloquent\BaseRepository', $repo);
        
        $fieldSearchable = ['name' => 'like',];
        $this->assertAttributeEquals($fieldSearchable, 'fieldSearchable', $repo);

        $this->assertEquals('NwManager\Entities\Client', $repo->model());
    }
}

