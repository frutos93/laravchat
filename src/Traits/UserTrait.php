<?php

namespace Frutdev\Laravchat\Traits;

trait UserTrait {

	public function messages() {
		return $this->hasMany('Frutdev\Laravchat\Models\Message');
	}

	public function threads() {
		return $this->belongsToMany('Frutdev\Laravchat\Models\Thread')->withPivot('last_seen', 'last_message');
	}
}