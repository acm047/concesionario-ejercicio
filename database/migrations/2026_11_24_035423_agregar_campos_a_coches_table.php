<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coches', function (Blueprint $table) {
            $table->string('marca', 30);
            $table->string('modelo', 30);
            $table->string('color', 40);
            $table->decimal('precio', 12, 2);
            $table->string('foto')->nullable();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::table('coches', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropColumn([
                'marca', 'modelo', 'color',
                'precio', 'foto', 'cliente_id'
            ]);
        });
    }
};
