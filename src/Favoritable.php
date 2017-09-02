<?php

namespace Viviniko\Favorite;

use Viviniko\Agent\Facades\Agent;
use Illuminate\Support\Facades\Config;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Config::get('favorite.favorite'), 'favoritable');
    }

    public function getIsFavoriteAttribute()
    {
        return $this->favorites()->where('client_id', Agent::clientId())->exists();
    }
}