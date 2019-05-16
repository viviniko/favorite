<?php

namespace Viviniko\Favorite\Facades;

use Illuminate\Support\Facades\Facade;

class Favorites extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Viviniko\Favorite\Repositories\FavoriteRepository::class;
    }
}