<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_conversations', function(Blueprint $table) {
			$table->increments('id');
			$table->string('team_channel_id', 255)->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('message_id')->nullable();
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
		Schema::drop('team_conversations');
	}

}
