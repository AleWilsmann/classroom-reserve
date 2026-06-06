<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Remove colunas do modelo antigo
            $table->dropColumn(['classroom', 'date', 'purpose']);

            // Adiciona colunas do novo modelo
            $table->string('title')->after('user_id');
            $table->foreignId('room_id')->after('title')->constrained()->onDelete('cascade');
            $table->foreignId('responsible_id')->after('room_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable()->after('responsible_id');

            // Altera start_time e end_time de time para datetime
            $table->dateTime('start_time')->change();
            $table->dateTime('end_time')->change();

            // Altera status para enum com os novos valores
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                  ->default('pending')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropForeign(['responsible_id']);
            $table->dropColumn(['title', 'room_id', 'responsible_id', 'description']);

            $table->string('classroom')->after('user_id');
            $table->date('date')->after('classroom');
            $table->time('start_time')->change();
            $table->time('end_time')->change();
            $table->string('purpose')->nullable();
            $table->string('status')->default('active')->change();
        });
    }
};