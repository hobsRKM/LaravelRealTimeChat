<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrackerFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracker_files', function(Blueprint $table) {
			$table->increments('id');
			$table->string('un_id', 255);
			$table->string('tracker_activity_un_id', 255)->nullable();
			$table->text('file_name', 65535)->nullable();
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
		Schema::drop('tracker_files');
	}

}
