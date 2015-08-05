<?php

namespace NwManager\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Carbon\Carbon;

class CarbonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $locale = config('app.locale');

        $path = base_path().'/resources/lang/'.$locale.'/carbon.php';
        if (file_exists($path)):
            $translator = new Translator($locale);
            $translator->addLoader('array', new ArrayLoader());
            $translator->addResource('array', require $path, $locale);
            Carbon::setTranslator($translator);
        endif;
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     *"Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
