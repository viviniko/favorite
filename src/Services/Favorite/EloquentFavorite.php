<?php

namespace Viviniko\Favorite\Services\Favorite;

use Viviniko\Agent\Facades\Agent;
use Viviniko\Favorite\Contracts\FavoriteService as FavoriteServiceInterface;
use Viviniko\Repository\SimpleRepository;
use Viviniko\Support\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class EloquentFavorite extends SimpleRepository implements FavoriteServiceInterface
{
    protected $modelConfigKey = 'favorite.favorite';

    protected $fieldSearchable = [
        'user_id',
    ];

    /**
     * @param $favoritable
     * @param null $user
     *
     * @return bool
     */
    public function isUserFavorite($favoritable, $user = null)
    {
        return in_array($favoritable->id, $this->getUserFavoritableIdsByType($favoritable->getMorphClass(), $user));
    }

    public function getUserFavoritableIdsByType($type, $user = null)
    {
        $where['favoritable_type'] = $type;
        if ($user) {
            $where['user_id'] = $user->id;
        } else if (Auth::check()) {
            $where['user_id'] = Auth::id();
        } else {
            $where['client_id'] = Agent::clientId();
        }

        return Cache::remember("favorite.user-favoritable-id-list.?:{$where['favoritable_type']}," . (isset($where['user_id']) ? $where['user_id'] : $where['client_id']), Config::get('cache.ttl', 10), function () use ($where) {
            return $this->createModel()->newQuery()->where($where)->get(['favoritable_id'])->pluck('favoritable_id')->toArray();
        });
    }

    /**
     * @param $userId
     * @param Model $favoritable
     * @return mixed
     */
    public function addUserFavoritable($favoritable)
    {
        $this->clearUserFavoriteCache($favoritable);
        $attributes = [
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
        ];
        $data = [];
        if (Auth::check()) {
            $attributes['user_id'] = Auth::id();
            $data['client_id'] = Agent::clientId();
        } else {
            $attributes['client_id'] = Agent::clientId();
            $data['user_id'] = 0;
        }
        return $this->createModel()->newQuery()->firstOrCreate($attributes, $data);
    }

    /**
     * @param Model $favoritable
     * @return mixed
     */
    public function removeUserFavoritable($favoritable)
    {
        $this->clearUserFavoriteCache($favoritable);
        $where = [
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
        ];
        if (Auth::check()) {
            $where['user_id'] = Auth::id();
        } else {
            $where['client_id'] = Agent::clientId();
        }

        return $this->createModel()->newQuery()->where($where)->delete();
    }

    /**
     * Sync customer client id.
     *
     * @param $userId
     * @param null $clientId
     * @return mixed
     */
    public function syncUserClientId($userId, $clientId = null)
    {
        $clientId = $clientId ?? Agent::clientId();
        $this->createModel()->newQuery()->where('client_id', $clientId)->update(['user_id' => $userId]);
        $this->createModel()->newQuery()->where('user_id', $userId)->where('client_id', '!=', $clientId)->update(['client_id' => $clientId]);
    }

    /**
     * @param $favoritable
     * @return int
     */
    public function count($favoritable)
    {
        return $this->createModel()->newQuery()->where([
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
        ])->count();
    }

    protected function clearUserFavoriteCache($favoritable)
    {
        $type = $favoritable->getMorphClass();
        if (Auth::check()) {
            Cache::forget("favorite.user-favoritable-id-list.?:{$type}," . Auth::id());
        }
        Cache::forget("favorite.user-favoritable-id-list.?:{$type}," . Agent::clientId());
    }
}