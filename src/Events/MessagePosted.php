<?php

namespace Frutdev\Laravchat\Events;

use App\User;
use Frutdev\Laravchat\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessagePosted implements ShouldBroadcast {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $message;
	public $sentToUser;
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Message $message, User $sendingUser, User $sentToUser) {
		$this->message = ['message' => $message->message, 'thread_id' => $message->thread_id, 'user_id' => $sendingUser->id, 'user_name' => $sendingUser->name];
		$this->sentToUser = ['id' => $sentToUser->id, 'name' => $sentToUser->name];
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn() {
		return new PrivateChannel('App.User.' . $this->sentToUser['id']);
	}
}
