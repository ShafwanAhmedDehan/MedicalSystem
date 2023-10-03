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
        Schema::create('doctors', function (Blueprint $table) {
            $table-> id();
            $table -> string('specialization');
            $table -> string('visitingDay')->nullable();
            $table -> integer('hospitalid');
            $table -> integer('patientcount') ->nullable();
            $table -> string('visitingTime') ->nullable();
            $table -> integer('uid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
