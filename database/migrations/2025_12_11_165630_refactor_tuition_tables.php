<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('tuition_bills');

        Schema::table('tuition_payments', function (Blueprint $table) {
            $table->string('month')->nullable(); // Add month back
            $table->year('year')->nullable(); // Add year back
            // status is already there, but we will use 'billed' as a value now
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_payments', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
        });

        // Re-create tuition_bills if needed, but we are deleting it permanently
    }
};
