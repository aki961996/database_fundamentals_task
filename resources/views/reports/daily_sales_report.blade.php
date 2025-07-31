@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daily Sales Report</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.daily') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="{{ $filters['end_date'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Order Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        @foreach(['pending', 'processing', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ ($filters['status'] ?? '') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('reports.daily') }}" class="btn btn-outline-secondary ms-2">Reset</a>
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
                            <th>Date</th>
                            <th>Orders</th>
                            <th>Total Sales</th>
                            <th>Avg. Order</th>
                            <th>Largest Order</th>
                            <th>Smallest Order</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailySales as $day)
                        <tr>
                            <td>{{ $day->date }}</td>
                            <td>{{ $day->order_count }}</td>
                            <td>${{ number_format($day->total_sales, 2) }}</td>
                            <td>${{ number_format($day->avg_order_value, 2) }}</td>
                            <td>${{ number_format($day->largest_order, 2) }}</td>
                            <td>${{ number_format($day->smallest_order, 2) }}</td>
                         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $dailySales->links() }}
            </div>
        </div>
    </div>
</div>
@endsection