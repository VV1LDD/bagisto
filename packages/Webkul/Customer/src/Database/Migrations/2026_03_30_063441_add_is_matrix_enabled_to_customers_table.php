<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * is_matrix_enabled removed; no-op for new installs. Existing DBs: column
     * removed in 2026_04_16_120000_remove_matrix_fields_*.
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
