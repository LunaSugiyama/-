<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mail_verifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mail_authentication');//認証コードの格納するカラム
            $table->string('mail')->unique();//メールアドレスを格納するカラム
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_verifications');
    }
};
