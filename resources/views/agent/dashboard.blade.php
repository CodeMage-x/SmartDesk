@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-cyan">
            <i class="fas fa-headset"></i> Agent Dashboard
        </h2>
        <div class="text-muted">
            Welcome back, {{ auth()->user()->name }}
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">My Tickets</h6>
                            <h3 class="text-cyan">{{ $myTickets }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-ticket-alt fa-2x text-cyan"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Open</h6>
                            <h3 class="text-danger">{{ $openTickets }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">In Progress</h6>
                            <h3 class="text-warning">{{ $inProgressTickets }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Resolved</h6>
                            <h3 class="text-success">{{ $resolvedTickets }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header card-header-cyan">
            <h5 class="mb-0">
                <i class="fas fa-list"></i> My Assigned Tickets
            </h5>
        </div>
        <div class="card-body">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td>#{{ $ticket->id }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->category->name }}</td>
                                <td>{{ $ticket->creator->name }}</td>
                                <td>
                                    <span class="badge {{ $ticket->getStatusBadgeClass() }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $ticket->getPriorityBadgeClass() }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-cyan">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @if($ticket->status !== 'closed')
                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" 
                                            data-bs-target="#updateStatusModal{{ $ticket->id }}">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No tickets assigned to you</p>
                </div>
            @endif
        </div>
    </div>
</div>

@foreach($tickets as $ticket)
<div class="modal fade" id="updateStatusModal{{ $ticket->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('agent.update-ticket-status', $ticket) }}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Update Ticket #{{ $ticket->id }} Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status{{ $ticket->id }}" class="form-label">Status</label>
                        <select class="form-select" id="status{{ $ticket->id }}" name="status" required>
                            <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="remarks{{ $ticket->id }}" class="form-label">Remarks (Optional)</label>
                        <textarea class="form-control" id="remarks{{ $ticket->id }}" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-cyan">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection