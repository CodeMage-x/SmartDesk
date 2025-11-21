@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-cyan">
            <i class="fas fa-user-plus"></i> Create New User
        </h2>
        <a href="{{ route('admin.users') }}" class="btn btn-outline-cyan">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-cyan">
                    <h5 class="mb-0">
                        <i class="fas fa-user"></i> User Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.store-user') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" 
                                    id="role" name="role" required onchange="toggleCategorySection()">
                                <option value="">Select Role</option>
                                <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>
                                    Super Admin
                                </option>
                                <option value="helpdesk_agent" {{ old('role') === 'helpdesk_agent' ? 'selected' : '' }}>
                                    Helpdesk Agent
                                </option>
                                <option value="end_user" {{ old('role') === 'end_user' ? 'selected' : '' }}>
                                    End User
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="categorySection" class="mb-3" style="display: none;">
                            <label class="form-label">Specialization Categories</label>
                            <div class="row">
                                @foreach($categories as $category)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="categories[]" value="{{ $category->id }}" 
                                               id="category{{ $category->id }}">
                                        <label class="form-check-label" for="category{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-cyan">
                                <i class="fas fa-save"></i> Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCategorySection() {
    const roleSelect = document.getElementById('role');
    const categorySection = document.getElementById('categorySection');
    
    if (roleSelect.value === 'helpdesk_agent') {
        categorySection.style.display = 'block';
    } else {
        categorySection.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleCategorySection();
});
</script>
@endsection