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
        return view('app');
    }
}