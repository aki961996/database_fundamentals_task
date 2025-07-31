@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Query Performance Analysis</h2>
    
    <div class="alert alert-info">
        Total Execution Time: <strong>{{ number_format($executionTime, 2) }}ms</strong> |
        Number of Queries: <strong>{{ count($queries) }}</strong>
    </div>

    @foreach($explainResults as $index => $analysis)
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Query #{{ $index + 1 }}</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h6>SQL Query:</h6>
                <div class="p-3 bg-light rounded">
                    <code>{{ $analysis['query'] }}</code>
                </div>
            </div>
            
            <div class="mb-3">
                <h6>Query Bindings:</h6>
                <div class="p-3 bg-light rounded">
                    <pre>{{ json_encode($analysis['bindings'], JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>

            @isset($analysis['error'])
                <div class="alert alert-danger">
                    <h6>EXPLAIN Error:</h6>
                    <p>{{ $analysis['error'] }}</p>
                </div>
            @else
                <div class="mb-3">
                    <h6>EXPLAIN Results:</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    @foreach($analysis['explain'][0] as $key => $value)
                                        <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($analysis['explain'] as $row)
                                <tr>
                                    @foreach($row as $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <h6>Performance Analysis:</h6>
                    <ul>
                        @php
                            $firstRow = $analysis['explain'][0];
                            $issues = [];
                            
                            if ($firstRow->type === 'ALL') {
                                $issues[] = "Full table scan detected - consider adding indexes";
                            }
                            if (strpos($firstRow->Extra, 'Using filesort') !== false) {
                                $issues[] = "Using filesort - optimize ORDER BY clauses";
                            }
                            if (strpos($firstRow->Extra, 'Using temporary') !== false) {
                                $issues[] = "Using temporary table - optimize GROUP BY clauses";
                            }
                            if ($firstRow->rows > 1000) {
                                $issues[] = "Examining many rows ({$firstRow->rows}) - consider better filtering";
                            }
                        @endphp

                        @if(count($issues))
                            @foreach($issues as $issue)
                                <li>{{ $issue }}</li>
                            @endforeach
                        @else
                            <li>No obvious performance issues detected</li>
                        @endif
                    </ul>
                </div>
            @endisset
        </div>
    </div>
    @endforeach
</div>
@endsection