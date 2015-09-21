<?php

namespace NwManager\Services;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;
use Illuminate\Support\MessageBag;

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
     * @var Illuminate\Contracts\Validation\Factory
     */
    protected $validator;

    /**
     * The Password Broker
     *
     * @var \Illuminate\Auth\Passwords\PasswordBroker
     */
    protected $password;

    /**
     * The password token repository.
     *
     * @var \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    protected $tokens;

    /**
     * Construct
     */
    public function __construct(Factory $validator)
    {
        $this->password = app('auth.password');
        $this->tokens = app('auth.password.tokens');
        $this->validator = $validator;
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
            $this->setError($e);
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
                $user->password = $password;
                $user->save();
            });
            
            if ($response != Password::PASSWORD_RESET) {
                $this->setError($response);
                return false;
            }

            return $response;

        } catch (\Exception $e) {
            $this->setError($e);
            return false;
        }
    }

    /**
     * Password Token
     */
    public function passwordToken(Request $request)
    {
        try {
            $credentials = $request->only('email', 'token');

            if (is_null($user = $this->password->getUser($credentials))) {
                throw new \Exception(trans(PasswordBrokerContract::INVALID_USER));
            }

            if (! $this->tokens->exists($user, $credentials['token'])) {
                throw new \Exception(trans(PasswordBrokerContract::INVALID_TOKEN));
            }

            return $user;

        } catch (\Exception $e) {
            $this->setError($e);
            return false;
        }
    }

    /**
     * Validate
     *
     * @param  Request $request
     * @param  array   $rules
     *
     * @throws ValidatorException
     */
    protected function validate(Request $request, array $rules)
    {
        $validator = $this->validator->make($request->all(), $rules);

        if( $validator->fails() ) {
            throw new ValidatorException( $validator->messages() );
        }

        return true;
    }

    /**
     * Set Error
     *
     * @param string|Exception $e
     *
     * @return void
     */
    protected function setError($e)
    {
        if ($e instanceof ValidatorException) {
            list($error, $error_description) = array_values($e->toArray());
            $error_description = $error_description->toArray();
        }

        elseif ($e instanceof \Exception) {
            $error = get_class($e);
            $error_description = $e->getMessage();
        }

        else {
            $error = strval($e);
            $error_description = trans($error);
        }

        $this->errors = compact('error', 'error_description');
    }

    /**
     * Get Errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
}