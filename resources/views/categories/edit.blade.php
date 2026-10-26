@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')

<div class="container-fluid py-4">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Edit Category</h2>
        <p class="text-muted mb-0">Update category information.</p>
    </div>

    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Categories
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

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

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">
                    Category Name <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ old('name', $category->name) }}"
                    maxlength="100"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">
                    Description
                </label>

                <textarea
                    name="description"
                    id="description"
                    class="form-control"
                    rows="4"
                    maxlength="2000"
                >{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-semibold">
                    Status <span class="text-danger">*</span>
                </label>

                <select name="status" id="status" class="form-select" required>
                    <option value="1"
                        {{ (string) old('status', (int) $category->status) === '1' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ (string) old('status', (int) $category->status) === '0' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Category
                </button>

                <a href="{{ route('categories.index') }}" class="btn btn-light border">
                    Cancel
                </a>
            </div>
        </form>

    </div>
</div>


</div>
@endsection
