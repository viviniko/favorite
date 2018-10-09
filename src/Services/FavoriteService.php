<?php

namespace Viviniko\Favorite\Services;

interface FavoriteService
{
    /**
     * Return the favorites count.
     * @param $favoritable
     * @return int
     */
    public function count($favoritable);
}