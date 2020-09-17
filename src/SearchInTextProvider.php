<?php


namespace SearchInText;


use Illuminate\Support\ServiceProvider;

/**
 * Class SearchInTextProvider
 * @package SearchInText
 */
class SearchInTextProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Search', function () {
            return new SearchLinks();
        });
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }


}
