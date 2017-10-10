<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastSeenAndLastMessageToThreadUserTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('thread_user', function (Blueprint $table) {
			$table->dateTime('last_seen')->nullable();
			$table->dateTime('last_message')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('thread_user', function (Blueprint $table) {
			$table->dropColumn(['last_seen', 'last_message']);
		});
	}
}
