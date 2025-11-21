@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-cyan">
            <i class="fas fa-ticket-alt"></i> Ticket #{{ $ticket->id }}
        </h2>
        <div>
            @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.tickets') }}" class="btn btn-outline-cyan">
                    <i class="fas fa-arrow-left"></i> Back to All Tickets
                </a>
            @elseif(Auth::user()->isHelpdeskAgent())
                <a href="{{ route('agent.dashboard') }}" class="btn btn-outline-cyan">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-cyan">
                    <i class="fas fa-arrow-left"></i> Back to My Tickets
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-cyan">
                    <h5 class="mb-0">{{ $ticket->title }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Category:</strong> {{ $ticket->category->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Priority:</strong> 
                            <span class="badge {{ $ticket->getPriorityBadgeClass() }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Created by:</strong> {{ $ticket->creator->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Created:</strong> {{ $ticket->created_at->format('M d, Y H:i') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Assigned to:</strong> 
                            @if($ticket->assignedAgent)
                                {{ $ticket->assignedAgent->name }}
                            @else
                                <span class="text-muted">Unassigned</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong> 
                            <span class="badge {{ $ticket->getStatusBadgeClass() }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>
                    </div>

                    <hr>
                    
                    <h6>Description:</h6>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($ticket->description)) !!}
                    </div>
                </div>
            </div>

            @if(Auth::user()->isHelpdeskAgent() && $ticket->assigned_to === Auth::id())
            <div class="card mt-4">
                <div class="card-header bg-warning">
                    <h6 class="mb-0">
                        <i class="fas fa-edit"></i> Update Ticket Status
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('agent.update-ticket-status', $ticket) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Update Notes</label>
                                <input type="text" name="remarks" class="form-control" 
                                       placeholder="Brief note about this update">
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-history"></i> Ticket History
                    </h6>
                </div>
                <div class="card-body">
                    @if($ticket->histories->count() > 0)
                        @foreach($ticket->histories->sortByDesc('created_at') as $history)
                        <div class="border-start border-info border-3 ps-3 mb-3">
                            <small class="text-muted">{{ $history->created_at->format('M d, Y H:i') }}</small>
                            <div>
                                <strong>{{ $history->actionBy->name }}</strong>
                                @if($history->old_status)
                                    changed status from 
                                    <span class="badge bg-secondary">{{ ucfirst($history->old_status) }}</span>
                                    to 
                                @else
                                    set status to 
                                @endif
                                <span class="badge bg-info">{{ ucfirst($history->new_status) }}</span>
                            </div>
                            @if($history->remarks)
                                <small class="text-muted">{{ $history->remarks }}</small>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted small">No history available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection