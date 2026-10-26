@extends('layouts.app')

@section('title', 'Add Product Category')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Add Product Category</h2>
            <p class="text-muted mb-0">Create a new product category.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Categories
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-lg-8 col-xl-7">

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-tag me-2 text-primary"></i>
                        Category Information
                    </h5>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        {{-- Category Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Category Name <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="e.g. Electronics"
                                maxlength="100"
                                required
                                autofocus
                            >

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">
                                Description
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                maxlength="2000"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter a short category description..."
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">
                                Category Status <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required
                            >
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-2">
                                Choose whether this category should be active or inactive.
                            </small>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Category
                            </button>

                            <a href="{{ route('categories.index') }}"
                               class="btn btn-light border">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

