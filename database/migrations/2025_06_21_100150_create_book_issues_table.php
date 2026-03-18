<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();

            // 🔗 Student (by library ID)
            $table->string('student_library_id');
            $table->foreign('student_library_id')
                  ->references('student_library_id')
                  ->on('students')
                  ->onDelete('cascade');

            // 🔗 Book
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')
                  ->references('id')
                  ->on('books')
                  ->onDelete('cascade');

            // 🔗 Issued by (admin user)
            $table->unsignedBigInteger('issued_by')->nullable();
            $table->foreign('issued_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            // 📅 Issue info
            $table->date('due_date')->nullable();
            $table->enum('book_condition', ['New', 'Good', 'Fair','Damaged']);
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('returned_at')->nullable(); // ✅ Return tracking
            $table->text('remark')->nullable();

            // 📊 Snapshot info
            $table->unsignedInteger('total_issued_book_count')->default(0); // ✅ Issued count at time of issue
            $table->string('book_status')->nullable(); // ✅ Book status at time of issue

            $table->timestamps();

            // Optional indexes for performance
            $table->index('student_library_id');
            $table->index('book_id');
            $table->index('issued_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_issues');
    }
};
