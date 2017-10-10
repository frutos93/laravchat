<?php

namespace Frutdev\Laravchat\Events;

use App\User;
use Frutdev\Laravchat\Models\Thread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadPosted implements ShouldBroadcast {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $thread;
	public $user_id;
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Thread $thread, User $user) {
		$this->thread = $thread;
		$this->user_id = $user->id;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn() {
		return new PrivateChannel('App.User.' . $this->user_id);
	}
}
