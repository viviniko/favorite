<?php

namespace Viviniko\Favorite\Contracts;

interface FavoriteService
{
    public function add($favoritable);

    public function remove($favoritable);

    /**
     * Paginate favorites.
     *
     * @param mixed $query
     *
     * @return \Common\Repository\Builder
     */
    public function search($query);

    /**
     * Sync customer client id.
     *
     * @param $userId
     * @param null $clientId
     * @return mixed
     */
    public function syncUserClientId($userId, $clientId = null);
}