<?php

namespace Viviniko\Favorite;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Config::get('favorite.favorite'), 'favoritable');
    }

    public function getIsFavoriteAttribute()
    {
        return Auth::check() && $this->favorites()->where('user_id', Auth::id())->exists();
    }
}