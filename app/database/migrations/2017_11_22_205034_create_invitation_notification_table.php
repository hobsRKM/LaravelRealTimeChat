<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvitationNotificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invitation_notification', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('team_id')->nullable();
			$table->integer('new_user')->nullable();
			$table->integer('team_user')->nullable();
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
		Schema::drop('invitation_notification');
	}

}
