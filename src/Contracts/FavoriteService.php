<?php

namespace Viviniko\Favorite\Contracts;

interface FavoriteService
{
    /**
     * Return the favorites count.
     * @param $favoritable
     * @return int
     */
    public function count($favoritable);
}