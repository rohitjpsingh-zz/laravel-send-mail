<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_mail', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('email');
            $table->string('description');
            $table->string('subject');
            $table->string('sender_email');
            $table->string('sender_fullname');
            $table->string('reply_to_email');
            $table->string('reply_to_fullname');
            $table->string('charset');
            $table->string('line_feed_after');
            $table->string('format');
            $table->string('measure_open_rate');
            $table->text('editor_text')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_mail');
    }
}
