<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_activities', function(Blueprint $table) {
			$table->increments('id');
			$table->string('un_id', 255);
			$table->string('tracker_id', 255)->nullable();
			$table->string('tracker_status_id', 255)->nullable();
			$table->string('tracker_priority_id', 255)->nullable();
			$table->text('tracker_subject', 65535)->nullable();
			$table->string('project_id', 255)->nullable();
			$table->integer('team_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->datetime('start_date')->nullable();
			$table->datetime('end_date')->nullable();
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
		Schema::drop('task_activities');
	}

}
