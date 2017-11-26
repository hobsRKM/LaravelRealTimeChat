<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskUpdatedActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_updated_activities', function(Blueprint $table) {
			$table->increments('id');
			$table->string('un_id', 255)->nullable();
			$table->string('parent_tracker_activity_un_id', 255)->nullable();
			$table->string('tracker_activity_un_id', 255)->nullable();
			$table->integer('by_user_id')->nullable();
			$table->integer('to_user_id')->nullable();
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
		Schema::drop('task_updated_activities');
	}

}
