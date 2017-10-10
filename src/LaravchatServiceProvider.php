<?php

namespace Frutdev\Laravchat;

use Illuminate\Support\ServiceProvider;

class LaravchatServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->loadViewsFrom(__DIR__ . '/Views', 'laravchat');
		$this->loadMigrationsFrom(__DIR__ . '/Migrations');

		$this->publishes([
			__DIR__ . '/Views' => base_path('resources/views/vendor/frutdev/laravchat'),
			__DIR__ . '/resources/js' => base_path('resources/assets/laravchatjs'),
			__DIR__ . '/resources/css' => base_path('public/css'),
		]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		include __DIR__ . '/routes.php';
		$this->app->make('Frutdev\Laravchat\Controllers\ChatController');

		//
	}
}
