<?php

namespace NwManager\Http\Controllers;

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
        return view('welcome');
    }
}