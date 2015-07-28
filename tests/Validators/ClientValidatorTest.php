<?php

namespace Tests\Validators;

use Tests\TestCase;
use Mockery as m;
use NwManager\Validators\ClientValidator;

class ClientValidatorTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $factory = m::mock('Illuminate\Validation\Factory');
        $validator = new ClientValidator($factory);

        $this->assertInstanceOf('NwManager\Validators\AbstractValidator', $validator);
        $this->assertInstanceOf('Prettus\Validator\LaravelValidator', $validator);
        
        $rules = [
            'create' => [
                'name'          => 'required|max:255',
                'responsible'   => 'required|max:255',
                'email'         => 'required|max:255|email',
                'phone'         => 'required|max:255',
                'address'       => 'required|max:255',
                'obs'           => 'required',
            ],
            'update' => [
                'name'          => 'max:255',
                'responsible'   => 'max:255',
                'email'         => 'max:255|email',
                'phone'         => 'max:255',
                'address'       => 'max:255',
            ],
        ];
        $this->assertAttributeEquals($rules, 'rules', $validator);
    }
}

