@extends('layouts.app')

@section('content')
<style>
    .glass-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
    }
    .form-control {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        background: transparent !important;
        color: var(--text-main) !important;
    }
    .category-item {
        transition: all 0.2s;
        border-bottom: 1px solid var(--border-color);
    }
    .category-item:hover {
        background: rgba(99, 102, 241, 0.05);
    }
    .cat-avatar {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary);
        color: white;
        border-radius: 12px;
        font-weight: bold;
    }
    /* Dropdown Styling */
    .dropdown-menu {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 8px;
    }
    .dropdown-item {
        border-radius: 8px;
        padding: 8px 16px;
    }
    .dropdown-item:hover {
        background: var(--primary);
        color: white;
    }
</style>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="mb-4">
                <h2 class="fw-bold mb-1">Categories</h2>
                <p class="text-muted">Organize your inventory groups.</p>
            </div>
            
            <div class="card glass-card shadow-sm p-4">
                <h5 class="fw-bold mb-4">Add New Category</h5>
                <form method="POST" action="{{ route('categories') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold opacity-75">Category Name</label>
                        <input type="text" name="category_name" class="form-control" placeholder="e.g. Electronics" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold opacity-75">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief details..."></textarea>
                    </div>

                    <button class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                        <i class="bi bi-plus-lg me-2"></i>Save Category
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card glass-card shadow-sm overflow-hidden">
                <div class="p-4 border-bottom bg-light bg-opacity-50 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Existing Categories</h6>
                    <span class="badge bg-primary rounded-pill">{{ $categories->count() }} Total</span>
                </div>
                
                <div class="list-group list-group-flush">
                    @forelse($categories as $category)
                    <div class="list-group-item category-item d-flex align-items-center p-4">
                        <div class="cat-avatar me-3">
                            {{ strtoupper(substr($category->category_name, 0, 1)) }}
                        </div>
                        
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0" style="color: var(--text-main)">{{ $category->category_name }}</h6>
                            <small class="text-muted">{{ Str::limit($category->description, 60) ?: 'No description provided.' }}</small>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-pencil-square me-2"></i>Edit Category
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-eye me-2"></i>View Products
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item text-danger" type="button">
                                        <i class="bi bi-trash3 me-2"></i>Delete
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @empty
                    <div class="p-5 text-center">
                        <i class="bi bi-tags text-muted display-1 opacity-25"></i>
                        <p class="mt-3 text-muted">No categories found. Create one to get started!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection