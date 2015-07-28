<?php

namespace Tests\Validators;

use Tests\TestCase;
use Mockery as m;
use NwManager\Validators\UserValidator;

class UserValidatorTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $factory = m::mock('Illuminate\Validation\Factory');
        $validator = new UserValidator($factory);

        $this->assertInstanceOf('NwManager\Validators\AbstractValidator', $validator);
        $this->assertInstanceOf('Prettus\Validator\LaravelValidator', $validator);
        
        $rules = [
            'create' => [
                'name'      => 'required|min:4|max:50',
                'username'  => 'required|min:4|max:30|regex:/^[a-zA-Z][a-zA-Z0-9_\.]+[a-zA-Z0-9]$/|unique:users,username',
                'email'     => 'max:255|email|unique:users,email',
                'password'  => 'required|alpha_num|min:6|max:12|confirmed',
                'password_confirmation' => 'required',
            ],
            'update' => [
                'name'      => 'min:4|max:50',
                'username'  => 'min:4|max:30|regex:/^[a-zA-Z][a-zA-Z0-9_\.]+[a-zA-Z0-9]$/|unique:users,username',
                'email'     => 'max:255|email|unique:users,email',
                'password'  => 'alpha_num|min:6|max:12|confirmed',
            ],
        ];
        $this->assertAttributeEquals($rules, 'rules', $validator);
    }
}

