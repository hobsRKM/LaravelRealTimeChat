<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('by_user_id')->nullable();
			$table->integer('to_user_id')->nullable();
			$table->string('task_id', 255)->nullable();
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
		Schema::drop('task_notifications');
	}

}
