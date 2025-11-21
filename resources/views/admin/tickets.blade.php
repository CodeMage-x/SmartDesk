@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-cyan">
            <i class="fas fa-tickets-alt"></i> Ticket Management
        </h2>
        <div>
            <select class="form-select d-inline-block" style="width: auto;" onchange="filterTickets(this.value)">
                <option value="">All Statuses</option>
                <option value="open">Open</option>
                <option value="in_progress">In Progress</option>
                <option value="resolved">Resolved</option>
                <option value="closed">Closed</option>
            </select>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted">Total Tickets</h6>
                            <h3 class="text-cyan">{{ $totalTickets }}</h3>
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
                            <h6 class="card-title text-muted">Unassigned</h6>
                            <h3 class="text-danger">{{ $unassignedTickets }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-slash fa-2x text-danger"></i>
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
                <i class="fas fa-list"></i> All Tickets
            </h5>
        </div>
        <div class="card-body">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="ticketsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Creator</th>
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
                            <tr data-status="{{ $ticket->status }}">
                                <td>#{{ $ticket->id }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->creator->name }}</td>
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
                                <td>{{ $ticket->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('tickets.show', $ticket) }}" 
                                           class="btn btn-outline-cyan" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button
                                            type="button"
                                            class="btn btn-outline-warning"
                                            title="Reassign"
                                            data-agents-url="{{ route('admin.agents.by-category', ['category' => $ticket->category_id]) }}"
                                            data-action-url="{{ route('admin.reassign-ticket', $ticket) }}"
                                            data-assigned="{{ $ticket->assigned_to ?? '' }}"
                                            onclick="showReassignModalFromBtn(this)"
                                            >
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{ $tickets->links() }}
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No tickets found</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reassign Modal -->
<div class="modal fade" id="reassignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reassign Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="reassignForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Agent</label>
                        <select name="agent_id" id="agentSelect" class="form-select" required>
                            <option value="">Choose an agent...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason for Reassignment</label>
                        <textarea name="remarks" class="form-control" rows="3" 
                                  placeholder="Optional reason for reassignment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Reassign Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
async function showReassignModalFromBtn(btn) {
  try {
    const agentsUrl = btn.dataset.agentsUrl;
    const actionUrl = btn.dataset.actionUrl;
    const assignedId = btn.dataset.assigned || null;

    const res = await fetch(agentsUrl, {
      headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      credentials: 'same-origin'
    });
    if (!res.ok) throw new Error(`Agents fetch failed (HTTP ${res.status})`);

    const agents = await res.json();

    const select = document.getElementById('agentSelect');
    select.innerHTML = '<option value="">Choose an agent...</option>';
    for (const a of agents) {
      const opt = document.createElement('option');
      opt.value = a.id; opt.textContent = a.name;
      if (assignedId && String(a.id) === String(assignedId)) opt.selected = true;
      select.appendChild(opt);
    }

    const form = document.getElementById('reassignForm');
    form.action = actionUrl;

    const modal = bootstrap?.Modal?.getOrCreateInstance(document.getElementById('reassignModal'));
    if (!modal) throw new Error('Bootstrap Modal not available (load bootstrap.bundle.min.js)');
    modal.show();
  } catch (e) {
    console.error(e);
    alert('Could not open Reassign dialog. See console and Network tab for details.');
  }
}
</script>
@endsection