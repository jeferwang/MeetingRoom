<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terms',
			function (Blueprint $table) {
				$table->increments('id');
				$table->string('termName')->comment('学期名称');
				$table->integer('startTime')->comment('开始日期');
				$table->integer('weekCount')->comment('学期总周数');
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
		Schema::dropIfExists('terms');
	}
}
