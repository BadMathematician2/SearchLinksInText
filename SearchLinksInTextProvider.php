<?php


namespace App\Packages\SearchLinksInText;


use Illuminate\Support\ServiceProvider;

class SearchLinksInTextProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('SearchLinks', function () {
            return new SearchLinksInText();
        });
    }

}
