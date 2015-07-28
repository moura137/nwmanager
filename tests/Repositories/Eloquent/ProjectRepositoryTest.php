<?php

namespace Tests\Repositories\Eloquent;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Eloquent\ProjectEloquentRepository;

class ProjectRepositoryTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $repo = new ProjectEloquentRepository($this->app);

        $this->assertInstanceOf('NwManager\Repositories\Contracts\ProjectRepository', $repo);
        $this->assertInstanceOf('NwManager\Repositories\Eloquent\AbstractEloquentRepository', $repo);
        $this->assertInstanceOf('Prettus\Repository\Eloquent\BaseRepository', $repo);
        
        $fieldSearchable = ['name' => 'like',];
        $this->assertAttributeEquals($fieldSearchable, 'fieldSearchable', $repo);

        $this->assertEquals('NwManager\Entities\Project', $repo->model());
    }
}

