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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('coach_slot');
        Schema::enableForeignKeyConstraints();


        Schema::create('coach_slot', function (Blueprint $table) {
            $table->unsignedBiginteger('horse_id');
            $table->unsignedBiginteger('coach_id');
            $table->unsignedBiginteger('slot_id');
            $table->unsignedBiginteger('rider_id');
            $table->timestamps();

            $table->foreign('horse_id')->references('id')->on('horses');
            $table->foreign('coach_id')->references('id')->on('coaches');
            $table->foreign('slot_id')->references('id')->on('slots');
            $table->foreign('rider_id')->references('id')->on('riders');
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
