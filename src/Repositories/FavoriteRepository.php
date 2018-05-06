<?php

namespace Viviniko\Favorite\Repositories;

interface FavoriteRepository
{
    /**
     * Paginate the given query into a simple paginator.
     *
     * @param $perPage
     * @param string $searchName
     * @param null $search
     * @param null $order
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $searchName = 'search', $search = null, $order = null);

    /**
     * Create entity.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Delete entity.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find by.
     *
     * @param $column
     * @param null $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($column, $value = null, $columns = ['*']);

    /**
     * Count by attributes.
     *
     * @param array $attributes
     * @return int
     */
    public function countBy(array $attributes);

}