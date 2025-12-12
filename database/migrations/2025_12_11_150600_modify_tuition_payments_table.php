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
        Schema::table('tuition_payments', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Parent ID
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_payments', function (Blueprint $table) {
            $table->string('month')->nullable();
            $table->year('year')->nullable();
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
