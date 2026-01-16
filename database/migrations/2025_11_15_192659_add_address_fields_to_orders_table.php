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
            $table->string('customer_province')->nullable()->after('customer_address');
            $table->string('customer_city')->nullable()->after('customer_province');
            $table->string('customer_postal_code')->nullable()->after('customer_city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_province', 'customer_city', 'customer_postal_code']);
        });
    }
};
