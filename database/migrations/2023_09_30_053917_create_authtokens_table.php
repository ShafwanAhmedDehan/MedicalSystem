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
        Schema::create('authtokens', function (Blueprint $table) {
            $table->id();
            $table->string('token',5000)->unique();
            $table->timestamp('tokencreated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authtokens');
    }
};
