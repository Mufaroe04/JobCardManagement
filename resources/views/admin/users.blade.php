@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Manage Users') }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin ? __('Admin') : __('User') }}</td>
                            <td>
                                 {{-- Removed the check for current user's ID --}}
                                    <form action="{{ route('users.toggleAdmin', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm {{ $user->is_admin ? 'btn-danger' : 'btn-success' }}">
                                            {{ $user->is_admin ? __('Remove Admin') : __('Make Admin') }}
                                        </button>
                                    </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
