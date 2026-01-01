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
        Schema::create('ventures', function (Blueprint $table) {
            $table->id();
            // Relación con entrepreneurs (id_perfil)
            $table->foreignId('entrepreneur_id')->constrained('entrepreneurs')->onDelete('cascade');

            // Relación con categories (id_categoria)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // Campos del emprendimiento
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventures');
    }
};
