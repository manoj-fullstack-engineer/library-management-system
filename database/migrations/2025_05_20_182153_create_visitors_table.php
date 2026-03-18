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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Some visitors may be anonymous, so nullable
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('purpose')->nullable();
            $table->string('address')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamp('visited_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};

