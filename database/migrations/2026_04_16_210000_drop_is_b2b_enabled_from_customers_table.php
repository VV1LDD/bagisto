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
        if (! Schema::hasColumn('customers', 'is_b2b_enabled')) {
            return;
        }

        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('is_b2b_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('customers', 'is_b2b_enabled')) {
            return;
        }

        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('is_b2b_enabled')->default(false)->after('is_call_enabled');
        });
    }
};
