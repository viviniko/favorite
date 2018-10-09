<?php

namespace Viviniko\Favorite\Services\Impl;

use Viviniko\Favorite\Services\FavoriteService;
use Viviniko\Favorite\Repositories\FavoriteRepository;

class FavoriteServiceImpl implements FavoriteService
{
    protected $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function count($favoritable)
    {
        return $this->favoriteRepository->count([
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
        ]);
    }
}