<?php

namespace Tests\Validators;

use Tests\TestCase;
use Mockery as m;
use NwManager\Validators\ProjectTaskValidator;

class ProjectTaskValidatorTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $factory = m::mock('Illuminate\Validation\Factory');
        $validator = new ProjectTaskValidator($factory);

        $this->assertInstanceOf('NwManager\Validators\AbstractValidator', $validator);
        $this->assertInstanceOf('Prettus\Validator\LaravelValidator', $validator);
        
        $rules = [
            'create' => [
                'project_id'    => 'required|exists:projects,id',
                'name'          => 'required|max:255',
                'start_date'    => 'required|date|date_format:d/m/Y',
                'due_date'      => 'required|date|date_format:d/m/Y',
                'status'        => 'required|in:1,2,3',
            ],
            'update' => [
                'project_id'    => 'exists:projects,id',
                'name'          => 'max:255',
                'start_date'    => 'date|date_format:d/m/Y',
                'due_date'      => 'date|date_format:d/m/Y',
                'status'        => 'in:1,2,3',
            ],
        ];
        $this->assertAttributeEquals($rules, 'rules', $validator);
    }
}

