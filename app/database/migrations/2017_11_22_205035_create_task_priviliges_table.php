<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskPriviligesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_priviliges', function(Blueprint $table) {
			$table->increments('id');
			$table->string('un_id', 255);
			$table->string('project_id', 255)->nullable();
			$table->string('team_id', 255)->nullable();
			$table->string('user_id', 255)->nullable();
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
		Schema::drop('task_priviliges');
	}

}
