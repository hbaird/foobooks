<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateBooksTable extends Migration {


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function($table) {


			# AI Primary key
			$table->increments('id');


			# Adds created_at and updated_at columns
			$table->timestamps();


			$table->string('title');
			$table->string('author');
			$table->integer('published');
			$table->string('cover');
			$table->string('purchase_link');
			$table->integer('user_id');
			$table->string('foobar');




		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('books');
	}


}
