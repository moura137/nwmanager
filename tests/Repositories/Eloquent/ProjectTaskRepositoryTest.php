<?php

namespace Tests\Repositories\Eloquent;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Eloquent\ProjectTaskEloquentRepository;

class ProjectTaskRepositoryTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $repo = new ProjectTaskEloquentRepository($this->app);

        $this->assertInstanceOf('NwManager\Repositories\Contracts\ProjectTaskRepository', $repo);
        $this->assertInstanceOf('NwManager\Repositories\Eloquent\AbstractEloquentRepository', $repo);
        $this->assertInstanceOf('Prettus\Repository\Eloquent\BaseRepository', $repo);
        
        $fieldSearchable = ['title' => 'like',];
        $this->assertAttributeEquals($fieldSearchable, 'fieldSearchable', $repo);

        $this->assertEquals('NwManager\Entities\ProjectTask', $repo->model());
    }
}

