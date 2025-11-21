@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-cyan">
            <i class="fas fa-tasks"></i> Available Tickets
        </h2>
        <div>
            <span class="badge bg-info">{{ $availableTickets->count() }} tickets available</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-cyan">
                    <h5 class="mb-0">
                        <i class="fas fa-hand-paper"></i> Tickets You Can Claim
                    </h5>
                </div>
                <div class="card-body">
                    @if($availableTickets->count() > 0)
                        @foreach($availableTickets as $ticket)
                        <div class="card mb-3 border-start border-warning border-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="card-title">
                                            #{{ $ticket->id }} - {{ $ticket->title }}
                                        </h6>
                                        <p class="card-text text-muted">{{ Str::limit($ticket->description, 100) }}</p>
                                        <div class="d-flex gap-2 mb-2">
                                            <span class="badge bg-secondary">{{ $ticket->category->name }}</span>
                                            <span class="badge {{ $ticket->getPriorityBadgeClass() }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                            <small class="text-muted">
                                                Created {{ $ticket->created_at->diffForHumans() }} by {{ $ticket->creator->name }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <form method="POST" action="{{ route('agent.claim-ticket', $ticket) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-cyan btn-sm">
                                                <i class="fas fa-hand-paper"></i> Claim Ticket
                                            </button>
                                        </form>
                                        <a href="{{ route('tickets.show', $ticket) }}" 
                                           class="btn btn-outline-cyan btn-sm">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tickets available for claiming</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-user-check"></i> My Assigned Tickets
                    </h6>
                </div>
                <div class="card-body">
                    @if($myTickets->count() > 0)
                        @foreach($myTickets as $ticket)
                        <div class="card mb-2 border-start border-info border-3">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-1">#{{ $ticket->id }} - {{ Str::limit($ticket->title, 30) }}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge {{ $ticket->getStatusBadgeClass() }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                    <a href="{{ route('tickets.show', $ticket) }}" 
                                       class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted small">No assigned tickets</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection