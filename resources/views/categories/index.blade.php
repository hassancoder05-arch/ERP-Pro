@extends('layouts.app')

@section('title', 'Category Management')

@section('content')

<style>
    .category-page {
        --category-primary: #4f46e5;
        --category-primary-dark: #4338ca;
        --category-border: #e5e7eb;
        --category-muted: #64748b;
        color: #0f172a;
    }

    .category-hero {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: 28px;
        color: #fff;
        background: linear-gradient(120deg, #312e81, #4f46e5 60%, #7c3aed);
        box-shadow: 0 10px 28px rgba(79, 70, 229, .16);
    }

    .category-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        right: -55px;
        top: -100px;
        border: 35px solid rgba(255,255,255,.08);
        border-radius: 50%;
        pointer-events: none;
    }

    .category-hero-content {
        position: relative;
        z-index: 1;
    }

    .category-hero .hero-icon {
        width: 54px;
        height: 54px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: rgba(255,255,255,.16);
        font-size: 23px;
    }

    .category-btn-light {
        background: #fff;
        color: #4338ca;
        border: 1px solid rgba(255,255,255,.4);
        font-weight: 600;
        border-radius: 10px;
        padding: 11px 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: .2s ease;
    }

    .category-btn-light:hover {
        background: #eef2ff;
        color: #312e81;
        transform: translateY(-1px);
    }

    .category-stat-card {
        background: #fff;
        border: 1px solid var(--category-border);
        border-radius: 15px;
        height: 100%;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .category-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(15,23,42,.07);
    }

    .category-stat-icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 19px;
        flex-shrink: 0;
    }

    .category-panel {
        background: #fff;
        border: 1px solid var(--category-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15,23,42,.035);
    }

    .category-panel-header {
        padding: 20px;
        border-bottom: 1px solid var(--category-border);
        background: #fff;
    }

    .category-search {
        min-width: 250px;
        max-width: 420px;
        width: 100%;
    }

    .category-search .form-control {
        border-radius: 10px 0 0 10px;
        border-color: #dbe1ea;
        padding: 10px 13px;
    }

    .category-search .btn {
        border-radius: 0 10px 10px 0;
        padding-inline: 16px;
    }

    .category-table {
        margin-bottom: 0;
    }

    .category-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .65px;
        text-transform: uppercase;
        padding: 15px 16px;
        white-space: nowrap;
        border-bottom: 1px solid var(--category-border);
    }

    .category-table tbody td {
        padding: 16px;
        border-color: #f1f5f9;
        vertical-align: middle;
    }

    .category-table tbody tr {
        transition: background .15s ease;
    }

    .category-table tbody tr:hover {
        background: #fafbff;
    }

    .category-name-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #eef2ff;
        color: #4f46e5;
        flex-shrink: 0;
    }

    .category-count-badge {
        min-width: 36px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 7px 11px;
        background: #eef2ff;
        color: #4338ca;
        border-radius: 9px;
        font-weight: 700;
    }

    .category-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 20px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .category-status-active {
        color: #15803d;
        background: #dcfce7;
    }

    .category-status-inactive {
        color: #64748b;
        background: #f1f5f9;
    }

    .category-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #fff;
        transition: all .15s ease;
    }

    .category-action:hover {
        transform: translateY(-1px);
    }

    .category-empty {
        padding: 55px 20px;
        text-align: center;
    }

    .category-empty-icon {
        width: 76px;
        height: 76px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border-radius: 22px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 30px;
        margin-bottom: 18px;
    }

    .category-footer {
        padding: 16px 20px;
        border-top: 1px solid var(--category-border);
        background: #fff;
    }

    .category-alert {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(15,23,42,.04);
    }

    @media (max-width: 767.98px) {
        .category-hero {
            padding: 22px 18px;
        }

        .category-panel-header {
            padding: 16px;
        }

        .category-search {
            min-width: 0;
            max-width: none;
        }

        .category-table thead th,
        .category-table tbody td {
            padding: 13px 12px;
        }
    }
</style>

<div class="container-fluid py-4 category-page">


{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show category-alert" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show category-alert" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger category-alert" role="alert">
        <div class="fw-bold mb-2">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Please correct the following errors:
        </div>

        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
>

{{-- Hero Header --}}
<div class="category-hero mb-4">
    <div class="category-hero-content d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div class="d-flex align-items-center gap-3">
            <div class="hero-icon">
                <i class="fas fa-layer-group"></i>
            </div>

            <div>
                <div class="small mb-1" style="color:#e0e7ff;">
                    ERP PRO / INVENTORY
                </div>

                <h2 class="fw-bold mb-1">Category Management</h2>

                <p class="mb-0" style="color:#e0e7ff;">
                    Organize and manage your product categories in one place.
                </p>
            </div>
        </div>

        <a href="{{ route('categories.create') }}" class="category-btn-light">
            <i class="fas fa-plus"></i>
            Add New Category
        </a>

    </div>
</div>

{{-- Statistics --}}
<div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="category-stat-card p-3">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                    <div class="text-muted small mb-2">Total Categories</div>
                    <h3 class="fw-bold mb-1">
                        {{ number_format($totalCategories ?? 0) }}
                    </h3>
                    <div class="text-muted small">All registered categories</div>
                </div>

                <div class="category-stat-icon" style="background:#eef2ff;color:#4f46e5;">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="category-stat-card p-3">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                    <div class="text-muted small mb-2">Active Categories</div>
                    <h3 class="fw-bold text-success mb-1">
                        {{ number_format($activeCategories ?? 0) }}
                    </h3>
                    <div class="text-muted small">Currently enabled</div>
                </div>

                <div class="category-stat-icon" style="background:#dcfce7;color:#15803d;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4">
        <div class="category-stat-card p-3">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div>
                    <div class="text-muted small mb-2">Inactive Categories</div>
                    <h3 class="fw-bold text-secondary mb-1">
                        {{ number_format($inactiveCategories ?? 0) }}
                    </h3>
                    <div class="text-muted small">Currently disabled</div>
                </div>

                <div class="category-stat-icon" style="background:#f1f5f9;color:#64748b;">
                    <i class="fas fa-ban"></i>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Main Categories Panel --}}
<div class="category-panel">

    <div class="category-panel-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div>
                <h5 class="fw-bold mb-1">All Categories</h5>
                <p class="text-muted small mb-0">
                    View, search, update or remove categories.
                </p>
            </div>

            <form action="{{ route('categories.index') }}"
                  method="GET"
                  class="category-search">

                <div class="input-group">
                    <input
                        type="search"
                        name="search"
                        class="form-control"
                        placeholder="Search by name or description..."
                        value="{{ $search ?? '' }}"
                        maxlength="100"
                        aria-label="Search categories"
                    >

                    <button type="submit" class="btn btn-primary" aria-label="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                @if(($search ?? '') !== '')
                    <div class="mt-2">
                        <a href="{{ route('categories.index') }}"
                           class="small text-decoration-none">
                            <i class="fas fa-times me-1"></i> Clear search
                        </a>
                    </div>
                @endif

            </form>

        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table category-table">

            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th class="text-center">Products</th>
                    <th>Status</th>
                    <th class="text-center pe-4">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)

                    <tr>
                        {{-- Number --}}
                        <td class="ps-4 text-muted small">
                            {{ $categories->firstItem() + $loop->index }}
                        </td>

                        {{-- Category Name --}}
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="category-name-icon">
                                    <i class="fas fa-folder"></i>
                                </div>

                                <div>
                                    <div class="fw-bold">
                                        {{ $category->name }}
                                    </div>

                                    <div class="text-muted small">
                                        Category ID: {{ $category->id }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Description --}}
                        <td>
                            <span class="text-muted">
                                @if($category->description)
                                    {{ \Illuminate\Support\Str::limit($category->description, 65) }}
                                @else
                                    <span class="fst-italic">No description</span>
                                @endif
                            </span>
                        </td>

                        {{-- Products Count --}}
                        <td class="text-center">
                            <span class="category-count-badge">
                                {{ number_format($category->products_count ?? 0) }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($category->status)
                                <span class="category-status category-status-active">
                                    <i class="fas fa-circle" style="font-size:7px;"></i>
                                    Active
                                </span>
                            @else
                                <span class="category-status category-status-inactive">
                                    <i class="fas fa-circle" style="font-size:7px;"></i>
                                    Inactive
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="text-center pe-4">
                            <div class="d-inline-flex align-items-center gap-1">

                                <a href="{{ route('categories.show', $category) }}"
                                   class="btn btn-sm btn-outline-info category-action"
                                   title="View category"
                                   aria-label="View category">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('categories.edit', $category) }}"
                                   class="btn btn-sm btn-outline-primary category-action"
                                   title="Edit category"
                                   aria-label="Edit category">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('categories.destroy', $category) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete the category: {{ addslashes($category->name) }}?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger category-action"
                                            title="Delete category"
                                            aria-label="Delete category">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6">
                            <div class="category-empty">

                                <div class="category-empty-icon">
                                    <i class="fas fa-folder-open"></i>
                                </div>

                                <h5 class="fw-bold mb-2">
                                    @if(($search ?? '') !== '')
                                        No matching categories
                                    @else
                                        No categories yet
                                    @endif
                                </h5>

                                <p class="text-muted mb-4">
                                    @if(($search ?? '') !== '')
                                        Try another keyword or clear your search.
                                    @else
                                        Create your first product category to get started.
                                    @endif
                                </p>

                                @if(($search ?? '') !== '')
                                    <a href="{{ route('categories.index') }}"
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Clear Search
                                    </a>
                                @else
                                    <a href="{{ route('categories.create') }}"
                                       class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>
                                        Create First Category
                                    </a>
                                @endif

                            </div>
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>
    </div>

    {{-- Pagination Footer --}}
    <div class="category-footer d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div class="text-muted small">
            @if($categories->total() > 0)
                Showing
                <strong>{{ $categories->firstItem() }}</strong>
                to
                <strong>{{ $categories->lastItem() }}</strong>
                of
                <strong>{{ $categories->total() }}</strong>
                categories
            @else
                No categories to display
            @endif
        </div>

        @if($categories->hasPages())
            <div>
                {{ $categories->links() }}
            </div>
        @endif

    </div>

</div>

{{-- Bottom Information --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
    <span class="text-muted small">
        <i class="fas fa-shield-alt me-1"></i>
        Category changes are managed through your ERP system.
    </span>

    <span class="text-muted small">
        ERP-Pro &bull; Category Management
    </span>
</div>


</div>

@endsection
