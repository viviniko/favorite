<?php

namespace Viviniko\Favorite;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait Favoritable
{
    public function favoritors()
    {
        return $this->morphMany(Config::get('favorite.favorite'), 'favoritable');
    }

    public function isFavoriteBy($userId)
    {
        return $this->favoritors()->where('user_id', $userId)->exists();
    }

    public function favoriteBy($userId)
    {
        $this->favoritors()->attach($userId);
    }

    public function unfavoriteBy($userId)
    {
        $this->favoritors()->detach($userId);
    }
}