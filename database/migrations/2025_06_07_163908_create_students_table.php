<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_library_id')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('contact_number')->nullable();
            $table->string('enrollment_no')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->string('department')->nullable();
            $table->string('course')->nullable();
            $table->string('year_semester')->nullable();
            $table->enum('membership_status', ['Active', 'Inactive', 'Suspended'])->default('Active');
            $table->integer('total_books_issued')->default(0);
            $table->integer('max_book_limit')->default(5);
            $table->decimal('fine_amount', 8, 2)->default(0.00);
            $table->boolean('blacklist_status')->default(false);
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('photo')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('password')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
