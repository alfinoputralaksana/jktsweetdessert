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
        Schema::table('orders', function (Blueprint $table) {
            // Add QRIS channel column (dana, gopay, ovo, linkaja) after qris_url
            $table->string('qris_channel')->nullable()->comment('QRIS payment channel: dana, gopay, ovo, linkaja')->after('virtual_account_bank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('qris_channel');
        });
    }
};
