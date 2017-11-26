<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamConversationsReadStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_conversations_read_status', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('team_channel_id')->nullable();
			$table->integer('message_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('read_status')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('team_conversations_read_status');
	}

}
