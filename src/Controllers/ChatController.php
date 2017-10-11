<?php

namespace Frutdev\Laravchat\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Frutdev\Laravchat\Events\MessagePosted;
use Frutdev\Laravchat\Events\ThreadPosted;
use Frutdev\Laravchat\Models\Message;
use Frutdev\Laravchat\Models\Thread;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller {

	/**
	 * Returns primary view of the chat
	 *
	 * @return view
	 */
	public function getIndex() {
		if (!Auth::check()) {
			return view('home');
		}
		return view('laravchat::index');
	}

	/**
	 * Returns logged in user.
	 *
	 * @return array
	 */
	public function getCurrentUser() {
		if (!Auth::check()) {
			return view('/');
		}
		return ['id' => Auth::user()->id, 'name' => Auth::user()->name];
	}

	/**
	 * Returns all available users, except the logged user.
	 *
	 * @return array
	 */
	public function getUsers() {
		if (!Auth::check()) {
			return view('/');
		}
		return User::where('id', '!=', Auth::user()->id)->select('id', 'name')->get();
	}

	/**
	 * Posts a message to $thread and creates the corresponding relation.
	 *
	 * @return array
	 */
	public function postThreadMessage(Thread $thread) {
		if (!Auth::check()) {
			return view('/');
		}
		$user = Auth::user();
		$usersInThread = $thread->users->where('id', '!=', $user->id);

		$message = $user->messages()->create([
			'message' => request()->get('message'),
			'thread_id' => $thread->id,
		]);

		$userThread = $user->threads->find($thread->id);
		$userThread->pivot->last_message = Carbon::now();
		$userThread->pivot->last_seen = Carbon::now();
		$userThread->pivot->save();

		foreach ($usersInThread as $userInThread) {
			$userThread = $userInThread->threads->find($thread->id);
			$userThread->pivot->last_message = Carbon::now();
			$userThread->pivot->save();
			broadcast(new MessagePosted($message, $user, $userInThread));
		}

		return ['message' => $message->message, 'user_id' => $message->user_id, 'thread_id' => $thread->id];
	}

	/**
	 * Returns all threads the user is associated to
	 *
	 * @return array
	 */
	public function getThreads() {
		if (!Auth::check()) {
			return view('/');
		}
		$user = Auth::user();
		$userThreads = [];
		foreach ($user->threads as $thread) {
			$userThread = $user->threads->find($thread->id);
			$newMessage = $userThread->pivot->last_message > $userThread->pivot->last_seen;
			array_push($userThreads, ['id' => $thread->id, 'title' => $thread->title, 'new' => $newMessage]);
		}
		return $userThreads;
	}

	/**
	 * Posts a thread an creates corresponding relations
	 *
	 * @return array
	 */
	public function postThread() {
		if (!Auth::check()) {
			return view('/');
		}
		$user = Auth::user();
		$userToStartThreadWith = User::find(request()->get('user'));

		$userThreads = $user->threads;
		foreach ($userThreads as $thread) {
			if ($userToStartThreadWith->threads->contains($thread)) {
				return ['status' => 'DUPLICATE'];
			}
		}
		$thread = new Thread;
		$thread->title = $user->name . ", " . $userToStartThreadWith->name;
		$thread->save();
		$user->threads()->save($thread);
		$userToStartThreadWith->threads()->save($thread);
		$newThread = ['id' => $thread->id, 'title' => $thread->title];

		broadcast(new ThreadPosted($thread, $userToStartThreadWith));

		return $newThread;
	}

	/**
	 * Returns all messages of a thread
	 *
	 * @return array
	 */
	public function getThreadMessages(Thread $thread) {
		if (!Auth::check()) {
			return view('/');
		}
		$messages = $thread->messages;
		$threadMessages = [];
		$user = Auth::user();
		foreach ($messages as $message) {
			array_push($threadMessages, ['message' => $message->message, 'user_id' => $message->user_id, 'user' => User::find($message->user_id)->name]);
		}
		$userThread = $user->threads->find($thread->id);
		$userThread->pivot->last_seen = Carbon::now();
		$userThread->pivot->save();
		return $threadMessages;
	}
}
