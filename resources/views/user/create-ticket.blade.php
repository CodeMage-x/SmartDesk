@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-cyan">
            <i class="fas fa-plus-circle"></i> Create New Support Ticket
        </h2>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-cyan">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4 border-info">
                <div class="card-body bg-light">
                    <h6 class="card-title text-info">
                        <i class="fas fa-info-circle me-2"></i>Before You Submit
                    </h6>
                    <ul class="mb-0">
                        <li>Provide a clear, descriptive title for your issue</li>
                        <li>Select the most appropriate category for faster resolution</li>
                        <li>Include detailed steps to reproduce the problem</li>
                        <li>Mention any error messages you've encountered</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header card-header-cyan">
                    <h5 class="mb-0">
                        <i class="fas fa-ticket-alt"></i> Ticket Details
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.store-ticket') }}" id="ticketForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="title" class="form-label">
                                    Issue Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="Brief, clear description of your issue"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <small>Example: "Unable to access email on mobile device"</small>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="priority" class="form-label">
                                    Priority Level <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority" required>
                                    <option value="">Select priority</option>
                                    <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>
                                        Low - Minor issue, can wait
                                    </option>
                                    <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>
                                        Medium - Normal business impact
                                    </option>
                                    <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>
                                        High - Urgent, affects productivity
                                    </option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">
                                Issue Category <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Choose the category that best describes your issue</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                        @if($category->description)
                                            - {{ $category->description }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>Selecting the right category helps us assign your ticket to the most qualified specialist</small>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                Detailed Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="6" 
                                      placeholder="Please provide a detailed description of your issue:&#10;&#10;• What were you trying to do?&#10;• What happened instead?&#10;• Any error messages you saw?&#10;• When did this start happening?&#10;• What device/software are you using?"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>The more details you provide, the faster we can resolve your issue</small>
                            </div>
                        </div>
                        
                        <div class="alert alert-info border-info">
                            <div class="row align-items-center">
                                <div class="col-md-1 text-center">
                                    <i class="fas fa-user-cog fa-2x text-info"></i>
                                </div>
                                <div class="col-md-11">
                                    <h6 class="alert-heading mb-1">Smart Assignment</h6>
                                    <p class="mb-0">
                                        Your ticket will be automatically assigned to a specialized IT agent based on the category you select. 
                                        You'll receive email notifications about updates and resolution progress.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-cyan btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Submit Support Ticket
                            </button>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel and Return to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle me-2"></i>Need Help?
                    </h6>
                </div>
                <div class="card-body">
                    <h6>Common Issues:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-wifi text-primary me-2"></i>
                            <strong>Network Issues:</strong> Select "Network & Connectivity"
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <strong>Email Problems:</strong> Select "Email & Communication"
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-desktop text-primary me-2"></i>
                            <strong>Software Issues:</strong> Select "Software & Applications"
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <strong>Security Concerns:</strong> Select "Security & Access"
                        </li>
                    </ul>
                    
                    <hr>
                    
                    <h6>Response Times:</h6>
                    <ul class="list-unstyled small">
                        <li><span class="badge bg-success">Low</span> Within 24 hours</li>
                        <li><span class="badge bg-warning text-dark">Medium</span> Within 4 hours</li>
                        <li><span class="badge bg-danger">High</span> Within 1 hour</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('ticketForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    
    if (title.length < 10) {
        e.preventDefault();
        alert('Please provide a more descriptive title (at least 10 characters)');
        return false;
    }
    
    if (description.length < 20) {
        e.preventDefault();
        alert('Please provide more details about your issue (at least 20 characters)');
        return false;
    }
});

document.getElementById('description').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});
</script>
@endsection