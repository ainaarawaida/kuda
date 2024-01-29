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
        //
        Schema::dropIfExists('coach_slot');
        Schema::create('coach_slot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('coach_id');
            $table->unsignedBiginteger('slot_id');


            $table->foreign('coach_id')->references('id')
                 ->on('coaches')->onDelete('cascade');
            $table->foreign('slot_id')->references('id')
                ->on('slots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
