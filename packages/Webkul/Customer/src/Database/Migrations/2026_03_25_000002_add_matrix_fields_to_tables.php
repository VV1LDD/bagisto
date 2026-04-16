<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Matrix (chat protocol) fields were removed. Kept as a no-op so existing
     * migration batches stay valid; columns are dropped by 2026_04_16_120000_*.
     */
    public function up(): void
    {
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
