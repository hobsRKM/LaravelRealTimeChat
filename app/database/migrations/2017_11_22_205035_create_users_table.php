<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name', 200)->nullable();
			$table->string('last_name', 200)->nullable();
			$table->string('password', 255)->nullable();
			$table->string('email', 60)->nullable();
			$table->integer('contact')->nullable();
			$table->string('remember_token', 255)->nullable();
			$table->string('profile_pic', 255)->nullable();
			$table->string('gender', 50);
			$table->string('birthday', 50);
			$table->text('summary', 65535);
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
		Schema::drop('users');
	}

}
