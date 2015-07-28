<?php

namespace Tests\Validators;

use Tests\TestCase;
use Mockery as m;
use NwManager\Validators\ProjectValidator;

class ProjectValidatorTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $factory = m::mock('Illuminate\Validation\Factory');
        $validator = new ProjectValidator($factory);

        $this->assertInstanceOf('NwManager\Validators\AbstractValidator', $validator);
        $this->assertInstanceOf('Prettus\Validator\LaravelValidator', $validator);
        
        $rules = [
            'create' => [
                'owner_id'      => 'required|exists:users,id',
                'client_id'     => 'required|exists:clients,id',
                'name'          => 'required|max:255',
                'description'   => 'required|max:255',
                'progress'      => 'required|max:255',
                'status'        => 'required|in:A,I',
                'due_date'      => 'required|date',
            ],
            'update' => [
                'owner_id'      => 'exists:users,id',
                'client_id'     => 'exists:clients,id',
                'name'          => 'max:255',
                'description'   => 'max:255',
                'progress'      => 'max:255',
                'status'        => 'in:A,I',
                'due_date'      => 'date',
            ],
        ];
        $this->assertAttributeEquals($rules, 'rules', $validator);
    }
}

