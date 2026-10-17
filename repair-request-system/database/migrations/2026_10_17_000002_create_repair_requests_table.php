<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repair_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no', 32)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('repair_categories')->restrictOnDelete();
            $table->string('title', 180);
            $table->text('description');
            $table->string('location', 180);
            $table->string('urgency', 20)->default('normal')->index();
            $table->string('status', 30)->default('pending')->index();
            $table->string('image_path')->nullable();
            $table->text('admin_note')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repair_requests');
    }
};
