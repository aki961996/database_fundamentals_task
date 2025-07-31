@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Customer order status Summary</h2>
    <!-- Example of displaying aggregate data -->
<table class="table">
    <thead>
        <tr>
            <th>Status</th>
            <th>Order Count</th>
            <th>Total Amount</th>
            <th>Average Order</th>
        </tr>
    </thead>
    <tbody>
        @foreach($statusSummary as $status)
        <tr>
            <td>{{ ucfirst($status->status) }}</td>
            <td>{{ $status->count }}</td>
            <td>${{ number_format($status->total_amount, 2) }}</td>
            <td>${{ number_format($status->total_amount / $status->count, 2) }}</td>
        </tr>
        @endforeach
        <tr class="table-primary">
            <td><strong>Total</strong></td>
            <td><strong>{{ $statusSummary->sum('count') }}</strong></td>
            <td><strong>${{ number_format($statusSummary->sum('total_amount'), 2) }}</strong></td>
            <td><strong>${{ number_format($statusSummary->sum('total_amount') / $statusSummary->sum('count'), 2) }}</strong></td>
        </tr>
    </tbody>
</table>
</div>
@endsection