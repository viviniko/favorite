<?php

namespace Viviniko\Favorite\Repositories;

use Illuminate\Support\Facades\Config;
use Viviniko\Repository\EloquentRepository;

class EloquentFavorite extends EloquentRepository implements FavoriteRepository
{
    public function __construct()
    {
        parent::__construct(Config::get('favorite.favorite'));
    }
}