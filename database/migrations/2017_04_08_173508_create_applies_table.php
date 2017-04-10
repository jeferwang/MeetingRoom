<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applies', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('room_id')->comment('申请的会议室ID');
			$table->integer('start_time')->comment('申请的开始时间');
			$table->integer('end_time')->comment('申请的结束时间');
			$table->string('people_name')->comment('预约者姓名');
			$table->string('people_tel')->comment('联系方式');
			$table->string('meeting_title')->comment('会议标题');
			$table->string('meeting_description')->nullable()->comment('会议概要');
			$table->srting('pass')->nullable()->comment('是否通过申请');
			$table->text('reason')->nullable()->comment('不通过的原因');
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
		Schema::dropIfExists('applies');
	}
}
