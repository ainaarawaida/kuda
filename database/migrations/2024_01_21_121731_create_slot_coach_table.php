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
        Schema::create('slot_coach', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('slot_id');
            $table->unsignedBiginteger('coach_id');


            $table->foreign('slot_id')->references('id')
                 ->on('slots')->onDelete('cascade');
            $table->foreign('coach_id')->references('id')
                ->on('coaches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot_coach');
    }
};
