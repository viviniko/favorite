<?php

namespace Viviniko\Favorite\Services\Favorite;

use Viviniko\Agent\Facades\Agent;
use Viviniko\Favorite\Contracts\FavoriteService as FavoriteServiceInterface;
use Viviniko\Repository\SimpleRepository;
use Viviniko\Support\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EloquentFavorite extends SimpleRepository implements FavoriteServiceInterface
{
    protected $modelConfigKey = 'favorite.favorite';

    protected $fieldSearchable = [
        'user_id',
    ];

    /**
     * @param $userId
     * @param Model $favoritable
     * @return mixed
     */
    public function add($favoritable)
    {
        return $this->createModel()->newQuery()->firstOrCreate([
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
            'client_id' => Agent::clientId(),
        ], ['user_id' => (int) Auth::id(),]);
    }

    /**
     * @param Model $favoritable
     * @return mixed
     */
    public function remove($favoritable)
    {
        return $this->createModel()->newQuery()->where([
            'favoritable_type' => $favoritable->getMorphClass(),
            'favoritable_id' => $favoritable->id,
            'client_id' => Agent::clientId(),
        ])->delete();
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
        return $this->createModel()->newQuery()->where('client_id', $clientId ?? Agent::clientId())->update(['user_id' => $userId]);
    }
}