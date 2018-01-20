<?php

namespace Viviniko\Favorite\Listeners;

use Viviniko\Favorite\Contracts\FavoriteService;
use Illuminate\Auth\Events\Login;

class UserEventSubscriber
{
	/**
	 * @var \Viviniko\Favorite\Contracts\FavoriteService
	 */
	private $favoriteService;

	public function __construct(FavoriteService $favoriteService)
    {
		$this->favoriteService = $favoriteService;
	}

	public function onLogin(Login $event)
    {
        $this->favoriteService->syncUserClientId($event->user->id);
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  \Illuminate\Events\Dispatcher  $events
	 */
	public function subscribe($events)
    {
		$events->listen(Login::class, 'Viviniko\Favorite\Listeners\UserEventSubscriber@onLogin');
	}
}
