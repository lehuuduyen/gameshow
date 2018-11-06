<?php

    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Routing\Router;

    /**
     * Class ExceptionsServiceProvider - Hacky?!
     * @package App\Providers
     */
    class ExceptionsServiceProvider extends ServiceProvider
    {
        /**
         * @return void
         */
        public function boot()
        {
        }

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register()
        {
            // app('Dingo\Api\Exception\Handler')->register(function (\Dingo\Api\Exception\ResourceException $exception) {
            //     $errors = $exception->getErrors();
            //
            //     return $errors->first();
            // });
        }
    }
