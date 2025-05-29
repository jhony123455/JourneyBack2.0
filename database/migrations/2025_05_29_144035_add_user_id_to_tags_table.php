<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero agregamos la columna sin restricciones
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
        });

        // Limpiamos los registros existentes si los hay
        DB::table('tags')->delete();

        // Ahora agregamos la restricción de llave foránea
        Schema::table('tags', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Hacemos la columna no nullable después de limpiar
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
