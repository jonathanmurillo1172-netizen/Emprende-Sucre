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
        Schema::table('ventures', function (Blueprint $table) {
            // Eliminar la clave foránea existente
            $table->dropForeign(['category_id']);
            
            // Hacer el campo nullable
            $table->foreignId('category_id')->nullable()->change();
            
            // Recrear la clave foránea con onDelete('set null')
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventures', function (Blueprint $table) {
            // Eliminar la clave foránea con set null
            $table->dropForeign(['category_id']);
            
            // Hacer el campo no nullable
            $table->foreignId('category_id')->nullable(false)->change();
            
            // Recrear la clave foránea original con cascade
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }
};
