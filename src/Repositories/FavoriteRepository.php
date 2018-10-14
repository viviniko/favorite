<?php

namespace Viviniko\Favorite\Repositories;

use Viviniko\Repository\SearchRequest;

interface FavoriteRepository
{
    /**
     * Search.
     *
     * @param SearchRequest $searchRequest
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function search(SearchRequest $searchRequest);

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
    public function count($attributes);

}