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
        Schema::create('m_users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('name')->nullable()->comment('氏名');
            $table->string('email')->unique();
            $table->tinyInteger('email_verified')->default(0)->comment('0=未確認、1=確認済');
            $table->string('email_verify_token')->nullable()->comment('email確認済になった後の識別トークン');
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('email_password_reset_verified')->default(0)->comment('0=未確認、1=未発行、2=確認済');
            $table->string('email_password_reset_token')->nullable()->comment('パスワードリセット用トークン');
            $table->timestamp('email_password_reset_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('m_users');
    }
};
