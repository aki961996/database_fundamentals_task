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
            $table->index(['order_date', 'status']);
            $table->index('customer_id');
            $table->index('total_amount');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index(['payment_date', 'status']);
            $table->index('order_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('email');
            $table->index('name');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['order_date', 'status']);
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['total_amount']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['payment_date', 'status']);
            $table->dropIndex(['order_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['name']);
        });
    }
};
