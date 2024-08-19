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
        Schema::rename('bill_detail', 'bill_details');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('bill_details', 'bill_detail');
    }
};
