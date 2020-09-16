<?php


namespace App\Packages\SearchLinksInText;


use Illuminate\Support\Facades\Facade;

class SearchLinksInTextFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SearchLinks';
    }
}
