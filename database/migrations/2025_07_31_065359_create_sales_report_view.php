<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW sales_report AS
           SELECT 
                o.id AS order_id,
                o.order_date,
                c.id AS customer_id,
                c.name AS customer_name,
                c.email AS customer_email,
                o.total_amount,
                o.status AS order_status,
                (SELECT SUM(amount) FROM payments p WHERE p.order_id = o.id AND p.status = 'completed') AS paid_amount,
                COUNT(oi.id) AS item_count,
                GROUP_CONCAT(DISTINCT oi.product_id) AS product_ids,
                GROUP_CONCAT(DISTINCT p.name SEPARATOR '|') AS product_names,
                MIN(oi.unit_price) AS min_price,
                MAX(oi.unit_price) AS max_price,
                (SELECT COUNT(*) FROM payments py WHERE py.order_id = o.id) AS payment_count,
                (SELECT MAX(payment_date) FROM payments py WHERE py.order_id = o.id) AS last_payment_date
            FROM orders o
            JOIN customers c ON o.customer_id = c.id
            LEFT JOIN order_items oi ON oi.order_id = o.id
            LEFT JOIN products p ON oi.product_id = p.id
            GROUP BY o.id, o.order_date, c.id, c.name, c.email, o.total_amount, o.status
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS sales_report");
    }
};
