<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_returns', function (Blueprint $table) {
            $table->id();

            $table->string('student_library_id');
            $table->unsignedBigInteger('book_id');
            $table->dateTime('issue_date');
            $table->dateTime('return_date');
            $table->string('condition_on_return')->nullable();
            $table->decimal('fine_amount', 8, 2)->default(0);
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();

            $table->foreign('processed_by')->references('id')->on('users')->onDelete('set null');

            $table->foreign('student_library_id')
                ->references('student_library_id')
                ->on('students')
                ->onDelete('cascade');

            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_returns');
    }
};
