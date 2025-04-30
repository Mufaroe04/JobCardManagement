@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Job Card') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('job-cards.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="job_title" class="col-md-4 col-form-label text-md-end">{{ __('Job Title') }}</label>

                            <div class="col-md-6">
                                <input id="job_title" type="text" class="form-control @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title') }}" required autofocus>

                                @error('job_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="client_name" class="col-md-4 col-form-label text-md-end">{{ __('Client Name') }}</label>

                            <div class="col-md-6">
                                <input id="client_name" type="text" class="form-control @error('client_name') is-invalid @enderror" name="client_name" value="{{ old('client_name') }}" required>

                                @error('client_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="job_description" class="col-md-4 col-form-label text-md-end">{{ __('Job Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="job_description" class="form-control @error('job_description') is-invalid @enderror" name="job_description" required>{{ old('job_description') }}</textarea>

                                @error('job_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="assigned_technician" class="col-md-4 col-form-label text-md-end">{{ __('Assigned Technician') }}</label>

                            <div class="col-md-6">
                                <input id="assigned_technician" type="text" class="form-control @error('assigned_technician') is-invalid @enderror" name="assigned_technician" value="{{ old('assigned_technician') }}">

                                @error('assigned_technician')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="estimated_completion_date" class="col-md-4 col-form-label text-md-end">{{ __('Estimated Completion Date') }}</label>

                            <div class="col-md-6">
                                <input id="estimated_completion_date" type="date" class="form-control @error('estimated_completion_date') is-invalid @enderror" name="estimated_completion_date" value="{{ old('estimated_completion_date') }}">

                                @error('estimated_completion_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Job Card') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection