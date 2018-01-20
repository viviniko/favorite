<?php

namespace Viviniko\Favorite\Contracts;

interface FavoriteService
{
    /**
     * @param $favoritable
     * @param $user
     * @return bool
     */
    public function isUserFavorite($favoritable, $user = null);

    /**
     * @param $favoritable
     * @return mixed
     */
    public function addUserFavoritable($favoritable);

    /**
     * @param $favoritable
     * @return mixed
     */
    public function removeUserFavoritable($favoritable);

    /**
     * @param $favoritable
     * @return int
     */
    public function count($favoritable);

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