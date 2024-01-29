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
        // Schema::table('coach_slot', function (Blueprint $table) {
        //     $table->dropColumn('rider_id');

         
        // });

        Schema::table('coach_slot', function (Blueprint $table) {
        
            $table
                ->foreignId('rider_id')
                ->after('slot_id')
                ->nullable()
                ->constrained('riders')
                ->nullOnDelete()->change();
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
