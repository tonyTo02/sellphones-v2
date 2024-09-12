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
        if (!Schema::hasColumn('customers', 'avatar')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('avatar')->default('avatars/avatar.jpg')->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('customers', 'avatar')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('avatar');
            });
        }
    }
};
