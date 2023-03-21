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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('email_verified')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verify_token')->nullable();
            //$table->rememberToken();
            $table->string('password');
            $table->rememberToken();
            $table->string('tfa_token')
                ->nullable();
            $table->dateTime('tfa_expiration')
                ->nullable();
            $table->string('login')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
