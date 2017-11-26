<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamHeadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_heads', function(Blueprint $table) {
			$table->increments('id');
			$table->string('project_id', 255)->nullable();
			$table->integer('team_id')->nullable();
			$table->integer('author_id')->nullable();
			$table->integer('user_id')->nullable();
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
		Schema::drop('team_heads');
	}

}
