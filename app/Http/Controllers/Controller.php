<?php

namespace NwManager\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class AbstractController
 *
 * @package NwManager\Http\Controllers;
 * @abstract
 */
abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
}
