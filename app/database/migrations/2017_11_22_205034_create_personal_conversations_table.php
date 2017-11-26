<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonalConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('personal_conversations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('from_user_id')->nullable();
			$table->integer('to_user_id')->nullable();
			$table->integer('message_id')->nullable();
			$table->string('team_channel_id', 255)->nullable();
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
		Schema::drop('personal_conversations');
	}

}
