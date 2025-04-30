@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            {{ __('Dashboard') }}
                            <a href="{{ route('job-cards.create') }}" class="btn btn-primary btn-sm">
                                {{ __('Create Job') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <h2>{{ __('Job Card List') }}</h2>

                        @if ($jobCards->isEmpty())
                            <p>{{ __('No job cards created yet.') }}</p>
                        @else
                            <div class="row">
                                @foreach ($jobCards as $jobCard)
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $jobCard->job_title }}</h5>
                                                <p class="card-text"><strong>{{ __('Client:') }}</strong>
                                                    {{ $jobCard->client_name }}</p>
                                                <p class="card-text"><strong>{{ __('Status:') }}</strong> {{ $jobCard->status }}</p>
                                                <p class="card-text"><strong>{{ __('Assigned Technician:') }}</strong>
                                                    {{ $jobCard->assigned_technician ?? '-' }}</p>
                                                    <p class="card-text"><strong>{{ __('Admin Comments:') }}</strong>
                                                    {{ $jobCard->admin_comments ?? 'No Admin Comments' }}</p>
                                                <p class="card-text"><strong>{{ __('Estimated Completion:') }}</strong>
                                                    {{ $jobCard->estimated_completion_date ? \Carbon\Carbon::parse($jobCard->estimated_completion_date)->format('Y-m-d') : '-' }}
                                                </p>
                                                <p class="card-text"><strong>{{ __('Created At:') }}</strong>
                                                    {{ $jobCard->created_at }}</p>
                                                @if (auth()->check() && auth()->user()->is_admin)
                                                    <div class="mt-3">
                                                        @if ($jobCard->status === 'Pending')
                                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#approveModal{{ $jobCard->id }}">
                                                                {{ __('Approve') }}
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm ms-1" data-bs-toggle="modal"
                                                                data-bs-target="#rejectModal{{ $jobCard->id }}">
                                                                {{ __('Reject') }}
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Approve Modal --}}
                                    <div class="modal fade" id="approveModal{{ $jobCard->id }}" tabindex="-1"
                                        aria-labelledby="approveModalLabel{{ $jobCard->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="approveModalLabel{{ $jobCard->id }}">
                                                        {{ __('Approve Job Card') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('job-cards.approve', $jobCard->id) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="admin_comments"
                                                                class="form-label">{{ __('Approval Comments (Optional)') }}</label>
                                                            <textarea class="form-control" id="admin_comments" name="admin_comments"
                                                                rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                        <button type="submit" class="btn btn-success">{{ __('Approve') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Reject Modal --}}
                                    <div class="modal fade" id="rejectModal{{ $jobCard->id }}" tabindex="-1"
                                        aria-labelledby="rejectModalLabel{{ $jobCard->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectModalLabel{{ $jobCard->id }}">
                                                        {{ __('Reject Job Card') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('job-cards.reject', $jobCard->id) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="admin_comments"
                                                                class="form-label">{{ __('Rejection Comments') }}</label>
                                                            <textarea class="form-control" id="admin_comments" name="admin_comments"
                                                                rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                        <button type="submit" class="btn btn-danger">{{ __('Reject') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection