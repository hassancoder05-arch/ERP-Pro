@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')

<div class="container-fluid py-5">

    <div class="text-center">

        <div class="display-1 fw-bold text-danger">
            403
        </div>

        <h2 class="fw-bold mt-3">
            Access Denied
        </h2>

        <p class="text-muted">
            You don't have permission to access this page.
        </p>

        <a
            href="{{ route('dashboard') }}"
            class="btn btn-primary"
        >
            <i class="bi bi-house me-2"></i>
            Back to Dashboard
        </a>

    </div>

</div>

@endsection