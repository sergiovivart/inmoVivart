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
        // Cambia la constraint de provincia_id para que apunte a 'provincias'
        // Si la columna ya existe (SQLite local), evitamos recrearla para no provocar errores
        $connection = Schema::getConnection()->getDriverName();

        Schema::table('cities', function (Blueprint $table) use ($connection) {
            if (Schema::hasColumn('cities', 'provincia_id')) {
                // Si la columna ya existe, y no estamos en sqlite, intentamos recrear la FK
                if ($connection !== 'sqlite') {
                    try {
                        $table->dropForeign(['provincia_id']);
                    } catch (\Throwable $e) {
                        // ignore
                    }

                    $table->foreign('provincia_id')->references('id')->on('provincias')->onDelete('cascade');
                }
                // Si es sqlite, no se puede alterar la tabla para añadir FK fácilmente, así que no hacemos nada
            } else {
                // La columna no existe; la creamos con la FK apuntando a 'provincias'
                $table->foreignId('provincia_id')->constrained('provincias')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            try {
                $table->dropForeign(['provincia_id']);
            } catch (\Throwable $e) {
                // ignore
            }

            // Restaurar la constraint anterior apuntando a 'cities' (como estaba originalmente)
            $table->foreignId('provincia_id')->constrained('cities')->onDelete('cascade');
        });
    }
};
