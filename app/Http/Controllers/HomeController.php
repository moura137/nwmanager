<?php

namespace NwManager\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class HomeController
 *
 * @package NwManager\Http\Controllers;
 */
class HomeController extends Controller
{
    /**
     * Action Index
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Action Login
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Action Forgot
     */
    public function forgot()
    {
        return view('forgot');
    }

    /**
     * Action Reset
     */
    public function reset(Request $request)
    {
        $data = $request->only('token', 'email');

        return view('reset', $data);
    }
}