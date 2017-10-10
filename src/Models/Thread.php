<?php

namespace Frutdev\Laravchat\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model {
	protected $table = 'threads';
	protected $fillable = ['title'];

	public function messages() {
		return $this->hasMany('Frutdev\Laravchat\Models\Message');
	}

	public function users() {
		return $this->belongsToMany('App\User')->withPivot('last_seen', 'last_message');
	}
}
