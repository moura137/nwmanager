<?php

namespace NwManager\Services;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AuthService
 *
 * @package NwManager\Services;
 */
class PasswordService
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * Construct
     */
    public function __construct()
    {
        $this->password = app('auth.password');
    }

    /**
     * Forgot Password
     */
    public function forgotPassword(Request $request)
    {
        try {
            $this->validate($request, ['email' => 'required|email']);

            $response = $this->password->sendResetLink($request->only('email'), function (Message $message) {
                $message->subject(trans('passwords.subject_reset_link'));
            });

            if ($response != Password::RESET_LINK_SENT) {
                $this->setError($response);
                return false;
            }

            return $response;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        try {
            $this->validate($request, [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
            ]);

            $credentials = $request->only(
                'email', 'password', 'password_confirmation', 'token'
            );

            $response = $this->password->reset($credentials, function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            });
            
            if ($response != Password::PASSWORD_RESET) {
                $this->setError($response);
                return false;
            }

            return $response;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }

    /**
     * Validate
     *
     * @param  Request $request
     * @param  array   $rules
     */
    protected function validate(Request $request, array $rules)
    {
        return true;
    }

    public function setError($error)
    {
        $this->errors = [
            'validation' => $error,
            'validation_description' => trans($error),
        ];
    }

    public function errors()
    {
        return $this->errors;
    }

    /**
     * Parse Error
     *
     * @param  \Exception $e
     *
     * @return array
     */
    protected function parseError(\Exception $e)
    {
        if ($e instanceof ValidatorException) {
            return $e->toArray();
        }

        return [
            'error' => 'error_internal',
            'error_description' => $e->getMessage(),
        ];
    }
}