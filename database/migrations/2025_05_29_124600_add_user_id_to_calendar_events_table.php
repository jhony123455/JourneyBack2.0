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
        // Primero agregamos la columna como nullable
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id');
        });

        // Asignamos los eventos al usuario del activity relacionado
        DB::statement('
            UPDATE calendar_events ce
            INNER JOIN activities a ON ce.activity_id = a.id
            SET ce.user_id = a.user_id
            WHERE ce.user_id IS NULL
        ');

        // Hacemos la columna no nullable y agregamos la llave foránea
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
