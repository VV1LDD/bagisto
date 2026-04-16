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
        $customerColumns = array_values(array_filter(
            ['is_matrix_enabled', 'matrix_user_id', 'matrix_access_token'],
            fn (string $column) => Schema::hasColumn('customers', $column)
        ));

        if ($customerColumns !== []) {
            Schema::table('customers', function (Blueprint $table) use ($customerColumns) {
                $table->dropColumn($customerColumns);
            });
        }

        if (Schema::hasColumn('handshakes', 'matrix_room_id')) {
            Schema::table('handshakes', function (Blueprint $table) {
                $table->dropColumn('matrix_room_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
