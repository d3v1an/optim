<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDownFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('down_files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('original_file');
			$table->string('compress_file');
			$table->bigInteger('file_size');
			$table->boolean('deleted');
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
		Schema::drop('down_files');
	}

}
