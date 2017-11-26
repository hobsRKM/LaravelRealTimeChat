<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamChannelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('team_channels', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('channel_name_id')->nullable();
			$table->string('team_channel_id', 255)->nullable();
			$table->integer('author_id')->nullable();
			$table->string('channel_view_name', 255)->nullable();
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
		Schema::drop('team_channels');
	}

}
