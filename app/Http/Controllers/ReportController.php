<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function recentOrders()
    {
        // $orders = Order::with(['customer', 'items.product'])
        //     ->orderBy('order_date', 'desc')
        //     ->limit(10)
        //     ->get();

        // return view('reports.recent_orders', compact('orders'));
        $recentOrders = Order::select([
            'orders.id',
            'orders.order_date',
            'orders.total_amount',
            'orders.status',
            'customers.name as customer_name',
            'customers.email as customer_email'
        ])
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->with(['items.product'])
            ->orderBy('orders.order_date', 'DESC')
            ->limit(10)
            ->get();

        return view('reports.recent_orders', compact('recentOrders'));
    }

    public function customerSales()
    {
        $customerSales = Customer::select([
            'customers.id',
            'customers.name',
            'customers.email',
            DB::raw('COUNT(orders.id) as order_count'),
            DB::raw('SUM(orders.total_amount) as total_sales')
        ])
            ->leftJoin('orders', 'customers.id', '=', 'orders.customer_id')
            ->groupBy('customers.id', 'customers.name', 'customers.email')
            ->orderBy('total_sales', 'DESC')
            ->get();

        return view('reports.customer_sales', compact('customerSales'));
    }
    // Filter data by date range and order status
    public function filteredOrders(Request $request)
    {
        $query = Order::with(['customer', 'items.product']);

        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('order_date', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $filteredOrders = $query->orderBy('order_date', 'DESC')
            ->paginate(15);

        return view('reports.filtered_orders', [
            'orders' => $filteredOrders,
            'oldInput' => $request->all()
        ]);
    }



    // Count of orders by status
    public function orderStatusSummary()
    {
        $statusSummary = Order::select([
            'status',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(total_amount) as total_amount')
        ])
            ->groupBy('status')
            ->get();

        return view('reports.order_status_summary', compact('statusSummary'));
    }

    // View for simplified reporting
    public function salesReport(Request $request)
    {
        $query = DB::table('sales_report')
            ->orderBy('order_date', 'DESC');

        // Apply filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('order_date', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }

        if ($request->filled('status')) {
            $query->where('order_status', $request->input('status'));
        }

        if ($request->filled('customer')) {
            $query->where('customer_id', $request->input('customer'));
        }

        if ($request->filled('min_amount')) {
            $query->where('total_amount', '>=', $request->input('min_amount'));
        }

        $reports = $query->paginate(25);

        // Get customers for filter dropdown
        $customers = Customer::orderBy('name')->get();

        return view('reports.sales_report', [
            'reports' => $reports,
            'customers' => $customers,
            'filters' => $request->all()
        ]);
    }
    public function dailySalesReport(Request $request)
    {

        $query = Order::select([
            DB::raw('DATE(order_date) as date'),
            DB::raw('COUNT(*) as order_count'),
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('AVG(total_amount) as avg_order_value'),
            DB::raw('MAX(total_amount) as largest_order'),
            DB::raw('MIN(total_amount) as smallest_order')
        ])
            ->groupBy('date')
            ->orderBy('date', 'DESC');


        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('order_date', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }


        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $dailySales = $query->paginate(30);

        return view('reports.daily_sales_report', [
            'dailySales' => $dailySales,
            'filters' => $request->all()
        ]);
    }


    public function queryPerformance()
    {
        DB::enableQueryLog();

        // Run a complex query that might need optimization
        $results = Order::with(['customer', 'items.product'])
            ->where('status', 'completed')
            ->whereBetween('order_date', [now()->subMonth(), now()])
            ->whereHas('payments', function ($query) {
                $query->where('status', 'completed')
                    ->where('amount', '>', 100);
            })
            ->orderBy('order_date', 'desc')
            ->take(50)
            ->get();

        $log = DB::getQueryLog();

        // Get EXPLAIN for all queries in the log
        $explainResults = [];
        foreach ($log as $index => $query) {
            try {
                $explainResults[$index] = [
                    'query' => $query['query'],
                    'bindings' => $query['bindings'],
                    'explain' => DB::select('EXPLAIN ' . $query['query'], $query['bindings'])
                ];
            } catch (\Exception $e) {
                $explainResults[$index] = [
                    'query' => $query['query'],
                    'bindings' => $query['bindings'],
                    'error' => $e->getMessage()
                ];
            }
        }

        return view('reports.query_performance', [
            'queries' => $log,
            'explainResults' => $explainResults,
            'executionTime' => array_sum(array_column($log, 'time'))
        ]);
    }
}
