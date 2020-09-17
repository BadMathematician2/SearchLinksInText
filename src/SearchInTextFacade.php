<?php


namespace SearchInText;


use Illuminate\Support\Facades\Facade;

/**
 * Class SearchInTextFacade
 * @package SearchInText
 */
class SearchInTextFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Search';
    }
}
