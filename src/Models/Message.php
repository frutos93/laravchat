<?php

namespace Frutdev\Laravchat\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'message', 'user_id', 'thread_id',
	];
	protected $table = 'messages';

	public function user() {
		return $this->belongsTo('App\User');
	}
	public function thread() {
		return $this->belongsTo('Frutdev\Laravchat\Models\Thread');
	}
}
