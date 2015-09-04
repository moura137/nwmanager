<?php

namespace NwManager\Http\Controllers;

/**
 * Class ThemeController
 *
 * @package NwManager\Http\Controllers;
 */
class ThemeController extends Controller
{
    /**
     * Action Page
     * 
     * @param string $uri Uri
     * 
     * @return View
     */
    public function page($uri)
    {
        $uri = preg_replace('/\.html$/', '', $uri);
        $template = "theme/templates/{$uri}";
        if (view()->exists($template)) {
            return view($template);
        }
        return abort(404);
    }
}
