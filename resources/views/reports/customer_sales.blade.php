@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Customer Sales Summary</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Email</th>
                <th>Orders</th>
                <th>Total Sales</th>
                <th>Avg. Order Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customerSales as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->order_count }}</td>
                <td>${{ number_format($customer->total_sales ?? 0, 2) }}</td>
                <td>${{ number_format($customer->order_count ? ($customer->total_sales / $customer->order_count) : 0, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection