<?php

namespace Viviniko\Favorite\Services\Favorite;

use Viviniko\Favorite\Contracts\FavoriteService as FavoriteServiceInterface;
use Viviniko\Favorite\Repositories\FavoriteRepository;

class FavoriteServiceImpl implements FavoriteServiceInterface
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
        return $this->favoriteRepository->countBy([
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
        ]);
    }
}