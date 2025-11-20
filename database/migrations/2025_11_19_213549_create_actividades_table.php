<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recordatorio_id')->constrained()->cascadeOnDelete();
            $table->string('descripcion');
            $table->string('estado')->default('pendiente');
            $table->text('nota')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actividades');
    }
};
