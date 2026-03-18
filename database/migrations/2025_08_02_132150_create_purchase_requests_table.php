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
    Schema::create('purchase_requests', function (Blueprint $table) {
        $table->id();
        $table->string('request_number')->unique();
        $table->string('item_name');
        $table->string('author')->nullable();
        $table->string('publisher')->nullable();
        $table->string('isbn')->nullable();
        $table->unsignedInteger('quantity')->default(1);
        $table->decimal('estimated_cost', 10, 2)->default(0);
        $table->foreignId('inventory_category_id')->constrained()->onDelete('cascade');
        $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
        $table->enum('status', ['pending', 'approved', 'rejected', 'ordered', 'received'])->default('pending');
        $table->text('remark')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
