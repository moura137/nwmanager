<?php

namespace Tests\Transformers;

use Tests\TestCase;
use NwManager\Transformers\ProjectTransformer;
use NwManager\Entities\Project;

use League\Fractal\TransformerAbstract;

class ProjectTransformerTest extends TestCase
{
    public function testTransform() {

        $transformer = new ProjectTransformer;

        $project = new Project([
            'id'            => '1',
            'name'          => 'NAME PROJECT',
            'description'   => 'DESCRICAO DO PROJECT',
            'progress'      => 2,
            'status'        => 1,
            'due_date'      => '2015-12-04',
            'created_at'    => '2015-08-06 13:06:33',
            'updated_at'    => '2015-08-06 14:51:22',
        ]);
        $project->setAttribute('id', 1);

        $expected = [
            'project_id'   => 1,
            'project'      => 'NAME PROJECT',
            'description'  => 'DESCRICAO DO PROJECT',
            'progress'     => 2,
            'status'       => 1,
            'due_date'     => '2015-12-04',
            // 'created_at'   => $model->created_at,
            // 'updated_at'   => $model->updated_at
        ];

        $this->assertEquals($expected, $transformer->transform($project));
    }
}