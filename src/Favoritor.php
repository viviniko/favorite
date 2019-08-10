<?php

namespace Viviniko\Favorite;

use Illuminate\Support\Facades\Config;

trait Favoritor
{
    public function favorites()
    {
        return $this->hasMany(Config::get('favorite.favorite'), 'user_id');
    }

    public function isFavorite($favoritable)
    {
        return $favoritable->isFavoriteBy($this->id);
    }

    public function favorite($favoritable)
    {
        $favoritable->favoriteBy($this->id);
        return $this;
    }

    public function unfavorite($favoritable)
    {
        $favoritable->unfavoriteBy($this->id);
        return $this;
    }
}