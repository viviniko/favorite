<?php

namespace Viviniko\Favorite\Services;

interface UserFavoriteService
{
    /**
     * @param $user
     * @return $this
     */
    public function setUser($user);

    /**
     * @return mixed
     */
    public function getUser();

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param $perPage
     * @param array $wheres
     * @param array $orders
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $wheres = [], $orders = []);

    /**
     * @param $favoritable
     * @param null $user
     *
     * @return bool
     */
    public function isFavorite($favoritable);

    /**
     * @param $favoritable
     * @param null $user
     * @return mixed
     */
    public function addFavorite($favoritable);

    /**
     * @param $favoritable
     * @return mixed
     */
    public function removeFavorite($favoritable);

    /**
     * Return the auth user favorites count.
     *
     * @return int
     */
    public function count();
}