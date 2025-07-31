@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Filtered Orders</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('orders.filtered') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="{{ old('start_date', $oldInput['start_date'] ?? '') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="{{ old('end_date', $oldInput['end_date'] ?? '') }}">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ ($oldInput['status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ ($oldInput['status'] ?? '') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ ($oldInput['status'] ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ ($oldInput['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('orders.filtered') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_date->format('Y-m-d H:i') }}</td>
                            <td>{{ $order->customer->name }}</td>
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
                                    <li>{{ $item->product->name }} ({{ $item->quantity }})</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection