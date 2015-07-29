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
            'create' => [
                'project_id'    => 'required|exists:project_notes,id',
                'title'         => 'required|max:255',
                'note'          => 'required',
            ],
            'update' => [
                'project_id'    => 'exists:project_notes,id',
                'title'         => 'max:255',
            ],
        ];
        $this->assertAttributeEquals($rules, 'rules', $validator);
    }
}

