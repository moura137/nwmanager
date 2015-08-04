<?php

namespace Tests\Validators;

use Tests\TestCase;
use Mockery as m;
use NwManager\Validators\ProjectNoteValidator;

class ProjectNoteValidatorTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $factory = m::mock('Illuminate\Validation\Factory');
        $validator = new ProjectNoteValidator($factory);

        $this->assertInstanceOf('NwManager\Validators\AbstractValidator', $validator);
        $this->assertInstanceOf('Prettus\Validator\LaravelValidator', $validator);
        
        $rules = [
            'project_id'    => 'required|exists:projects,id',
            'user_id'       => 'required|exists:users,id',
            'title'         => 'required|max:255',
            'note'          => 'required',
        ];
        $this->assertAttributeEquals($rules, 'rules', $validator);
    }
}

