@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Job Card Reports') }}</div>

                <div class="card-body">
                    <h2>{{ __('Summary') }}</h2>
                    <p>{{ __('Total Job Cards:') }} <strong>{{ $total }}</strong></p>
                    <p>{{ __('Approved:') }} <strong>{{ $approved }}</strong></p>
                    <p>{{ __('Pending:') }} <strong>{{ $pending }}</strong></p>
                    <p>{{ __('Rejected:') }} <strong>{{ $rejected }}</strong></p>

                    <hr>

                    <h2>{{ __('Filter by Date Range') }}</h2>
                    <form method="GET" action="{{ route('reports') }}">
                        <div class="row mb-3">
                            <label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                                <a href="{{ route('reports') }}" class="btn btn-secondary ms-2">{{ __('Reset Filter') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection