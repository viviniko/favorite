<?php

namespace Viviniko\Favorite\Services\Favorite;

use Viviniko\Favorite\Contracts\UserFavoriteService as UserFavoriteServiceInterface;
use Viviniko\Favorite\Repositories\FavoriteRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class UserFavoriteServiceImpl implements UserFavoriteServiceInterface
{
    protected $favoriteRepository;

    protected $user;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function checkIssetUser()
    {
        if (!$this->getUser()) {
            throw new \Exception('User must be not null.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function paginate($perPage, $filter = null, $order = null)
    {
        $this->checkIssetUser();

        return $this->favoriteRepository->paginate(
            $perPage,
            'search',
            array_merge(['user_id' => $this->getUserKey()], is_array($filter) ? $filter : []),
            $order
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isFavorite($favoritable)
    {
        $this->checkIssetUser();

        return in_array($favoritable->id, $this->getFavoritableIdsByType($favoritable->getMorphClass()));
    }

    public function getFavoritableIdsByType($type)
    {
        if (!$this->getUser())
            return [];

        $userId = $this->getUserKey();
        return Cache::remember("favorite.user-favoritable-id-list.?:{$type},{$userId}", Config::get('cache.ttl', 10), function () use ($type, $userId) {
            return $this->favoriteRepository
                ->findBy(['favoritable_type' => $type, 'user_id' => $userId], null, ['favoritable_id'])
                ->pluck('favoritable_id')
                ->toArray();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function addFavorite($favoritable)
    {
        $this->checkIssetUser();
        $this->clearFavoriteCache($favoritable);
        $data = [
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
            'user_id' => $this->getUserKey()
        ];

        $favorite = $this->favoriteRepository->findBy($data)->first();
        if (!$favorite) {
            $this->favoriteRepository->create($data);
        }

        return $favorite;
    }

    /**
     * {@inheritdoc}
     */
    public function removeFavorite($favoritable)
    {
        $this->checkIssetUser();
        $this->clearFavoriteCache($favoritable);

        $favorite = $this->favoriteRepository->findBy([
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
            'user_id' => $this->getUserKey()
        ])->first();

        return $favorite ? $this->favoriteRepository->delete($favorite->id) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        $this->checkIssetUser();

        return $this->favoriteRepository->countBy(['user_id' => $this->getUserKey()]);
    }

    protected function clearFavoriteCache($favoritable)
    {
        if ($this->getUser()) {
            $type = $favoritable->getMorphClass();
            Cache::forget("favorite.user-favoritable-id-list.?:{$type}," . $this->getUserKey());
        }
    }

    protected function getUserKey()
    {
        return $this->getUser()->id;
    }
}