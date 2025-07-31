@extends('layouts.app')

@section('content')
<div class="container">
    <h2> Sales Report</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('sales.report') }}" class="row g-3">
                <div class="col-md-2">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="{{ $filters['end_date'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        @foreach(['pending', 'processing', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ ($filters['status'] ?? '') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="customer" class="form-label">Customer</label>
                    <select class="form-select" id="customer" name="customer">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ ($filters['customer'] ?? '') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="min_amount" class="form-label">Min Amount</label>
                    <input type="number" class="form-control" id="min_amount" name="min_amount" 
                           step="0.01" min="0" value="{{ $filters['min_amount'] ?? '' }}">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
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
                            <th>Paid</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th>Products</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->order_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->order_date)->format('Y-m-d') }}</td>
                            <td>
                                {{-- <a href="{{ route('customers.show', $report->customer_id) }}"> --}}
                                    {{ $report->customer_name }}
                                {{-- </a> --}}
                            </td>
                            <td>${{ number_format($report->total_amount, 2) }}</td>
                            <td>${{ number_format($report->paid_amount ?? 0, 2) }}</td>
                            <td>{{ $report->item_count }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $report->order_status == 'completed' ? 'success' : 
                                    ($report->order_status == 'processing' ? 'primary' : 
                                    ($report->order_status == 'cancelled' ? 'danger' : 'warning')) 
                                }}">
                                    {{ ucfirst($report->order_status) }}
                                </span>
                            </td>
                            <td>
                                @foreach(explode('|', $report->product_names) as $product)
                                    <span class="badge bg-info text-dark mb-1">{{ $product }}</span>
                                @endforeach
                            </td>
                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection