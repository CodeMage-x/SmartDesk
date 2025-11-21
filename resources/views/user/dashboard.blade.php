@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-cyan">
            <i class="fas fa-tachometer-alt"></i> My Dashboard
        </h2>
        <a href="{{ route('user.create-ticket') }}" class="btn btn-cyan">
            <i class="fas fa-plus"></i> Create New Ticket
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Total Tickets</h6>
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
                            <h3 class="text-warning">{{ $openTickets }}</h3>
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
                            <h6 class="card-title text-muted">In Progress</h6>
                            <h3 class="text-info">{{ $inProgressTickets }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-cogs fa-2x text-info"></i>
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
                <i class="fas fa-list"></i> My Recent Tickets
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
                                <th>Assigned To</th>
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
                                <td>{{ Str::limit($ticket->title, 50) }}</td>
                                <td>{{ $ticket->category->name }}</td>
                                <td>
                                    @if($ticket->assignedAgent)
                                        <span class="badge bg-info">{{ $ticket->assignedAgent->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Unassigned</span>
                                    @endif
                                </td>
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
                                    <a href="{{ route('tickets.show', $ticket) }}" 
                                       class="btn btn-outline-cyan btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">No tickets yet</h6>
                    <p class="text-muted mb-3">Create your first support ticket to get started</p>
                    <a href="{{ route('user.create-ticket') }}" class="btn btn-cyan">
                        <i class="fas fa-plus me-2"></i>Create Your First Ticket
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection