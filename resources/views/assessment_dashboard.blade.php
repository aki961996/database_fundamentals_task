

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Database Fundamentals Challenge</h2>
                </div>
                
                <div class="card-body">
                    <h4 class="mb-4">Technical Assessment Dashboard</h4>
                    
                    <div class="row">
                        <!-- Database Basics Section -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Database Basics</h5>
                                </div>
                                <div class="card-body">
                                    <p>Master and transaction tables implementation</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <a href="{{ route('recent.orders') }}" class="btn btn-outline-primary btn-block">
                                                View Recent Orders
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ route('customer.sales') }}" class="btn btn-outline-primary btn-block">
                                                Customer Sales Report
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Querying and Joins Section -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Querying and Joins</h5>
                                </div>
                                <div class="card-body">
                                    <p>Advanced query implementations</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <a href="{{ route('orders.filtered') }}" class="btn btn-outline-primary btn-block">
                                                Filtered Orders
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ route('status.summary') }}" class="btn btn-outline-primary btn-block">
                                                Order Status Summary
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Report Generation Section -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Report Generation</h5>
                                </div>
                                <div class="card-body">
                                    <p>Optimized reporting solutions</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <a href="{{ route('reports.daily') }}" class="btn btn-outline-primary btn-block">
                                                Daily Sales Report
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ route('sales.report') }}" class="btn btn-outline-primary btn-block">
                                                Comprehensive Sales Report
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Optimization Section -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Optimization</h5>
                                </div>
                                <div class="card-body">
                                    <p>Performance analysis tools</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <a href="{{ route('query.performance') }}" class="btn btn-outline-primary btn-block">
                                                Query Performance Analysis
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <button class="btn btn-outline-secondary btn-block" disabled>
                                                Database Indexes (Implemented in Migrations)
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer text-muted">
                    <small>Database Fundamentals Challenge - Technical Assessment</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
