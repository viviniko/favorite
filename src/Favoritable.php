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

    public function isFavorite($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    public function countFavoriteBy($userId)
    {
        return $this->favorites()->where('user_id', $userId)->count();
    }

    public function getIsFavoriteAttribute()
    {
        return Auth::check() && $this->isFavorite(Auth::id());
    }

    public function favoriteBy($userId)
    {
        $this->favorites()->attach($userId);
    }

    public function unfavoriteBy($userId)
    {
        $this->favorites()->detach($userId);
    }
}