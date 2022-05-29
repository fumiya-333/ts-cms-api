<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_send_mails', function (Blueprint $table) {
            $table->uuid('send_mail_id')->primary();
            $table->string('email')->comment('メールアドレス');
            $table->string('subject')->comment('件名');
            $table->text('message')->comment('本文');
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
        Schema::dropIfExists('t_send_mails');
    }
};
