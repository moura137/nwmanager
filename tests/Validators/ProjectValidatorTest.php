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
            'owner_id'      => 'required|exists:users,id',
            'client_id'     => 'required|exists:clients,id',
            'name'          => 'required|max:255',
            'progress'      => 'required|integer|min:0|max:100',
            'status'        => 'required|in:1,2,3',
            'due_date'      => 'required|date',
        ];
        $this->assertAttributeEquals($rules, 'rules', $validator);
    }
}

