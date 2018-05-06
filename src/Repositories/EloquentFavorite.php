<?php

namespace Viviniko\Favorite\Repositories;

use Viviniko\Repository\SimpleRepository;

class EloquentFavorite extends SimpleRepository implements FavoriteRepository
{
    protected $modelConfigKey = 'favorite.favorite';

    protected $fieldSearchable = [
        'user_id',
    ];

    /**
     * {@inheritdoc}
     */
    public function countBy(array $attributes)
    {
        return $this->createModel()->newQuery()->where($attributes)->count();
    }
}