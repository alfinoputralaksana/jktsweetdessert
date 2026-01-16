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
            $table->enum('delivery_type', ['self_pickup', 'delivery'])->default('delivery')->after('customer_address');
            $table->string('midtrans_transaction_id')->nullable()->after('payment_reference');
            $table->string('midtrans_order_id')->nullable()->after('midtrans_transaction_id');
            $table->text('payment_instructions')->nullable()->after('midtrans_order_id');
            $table->string('virtual_account_number')->nullable()->after('payment_instructions');
            $table->string('qris_url')->nullable()->after('virtual_account_number');
            $table->timestamp('payment_expired_at')->nullable()->after('qris_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_type',
                'midtrans_transaction_id',
                'midtrans_order_id',
                'payment_instructions',
                'virtual_account_number',
                'qris_url',
                'payment_expired_at'
            ]);
        });
    }
};
