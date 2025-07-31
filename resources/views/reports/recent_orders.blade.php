@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Recent Orders (Last 10)</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Items</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->order_date->format('Y-m-d H:i') }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->customer_email }}</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
                <td>
                    <span class="badge bg-{{ 
                        $order->status == 'completed' ? 'success' : 
                        ($order->status == 'processing' ? 'primary' : 
                        ($order->status == 'cancelled' ? 'danger' : 'warning')) 
                    }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>
                    <ul class="list-unstyled">
                        @foreach($order->items as $item)
                        <li>{{ $item->product->name }} ({{ $item->quantity }} × ${{ $item->unit_price }})</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection