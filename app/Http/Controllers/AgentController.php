<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function dashboard()
    {
        $agent = Auth::user();
        
        $myTickets = $agent->assignedTickets()->count();
        $openTickets = $agent->assignedTickets()->where('status', 'open')->count();
        $inProgressTickets = $agent->assignedTickets()->where('status', 'in_progress')->count();
        $resolvedTickets = $agent->assignedTickets()->where('status', 'resolved')->count();
        
        $tickets = $agent->assignedTickets()
            ->with(['creator', 'category'])
            ->latest()
            ->get();

        return view('agent.dashboard', compact(
            'myTickets', 
            'openTickets', 
            'inProgressTickets', 
            'resolvedTickets', 
            'tickets'
        ));
    }

    public function ticketsPool()
    {
        $agent = Auth::user();
        
        $availableTickets = Ticket::whereHas('category.agents', function($query) use ($agent) {
            $query->where('agent_id', $agent->id);
        })
        ->whereNull('assigned_to')
        ->where('status', 'open')
        ->with(['creator', 'category'])
        ->latest()
        ->get();

        
        $myTickets = $agent->assignedTickets()
            ->whereIn('status', ['open', 'in_progress'])
            ->with(['category'])
            ->latest()
            ->get();

        return view('agent.tickets-pool', compact('availableTickets', 'myTickets'));
    }

    public function claimTicket(Ticket $ticket)
    {
        $agent = Auth::user();
        
        
        $canClaim = $ticket->category->agents()->where('agent_id', $agent->id)->exists();
        
        if (!$canClaim) {
            return redirect()->back()->with('error', 'You cannot claim this ticket.');
        }

        if ($ticket->assigned_to) {
            return redirect()->back()->with('error', 'This ticket is already assigned.');
        }

        $ticket->update([
            'assigned_to' => $agent->id,
            'status' => 'in_progress'
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'action_by' => $agent->id,
            'old_status' => 'open',
            'new_status' => 'in_progress',
            'remarks' => 'Ticket claimed by agent',
        ]);

        return redirect()->back()->with('success', 'Ticket claimed successfully.');
    }

    public function updateTicketStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'remarks' => 'nullable|string',
        ]);

        $oldStatus = $ticket->status;
        $ticket->update(['status' => $request->status]);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'action_by' => Auth::id(),
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('success', 'Ticket status updated successfully.');
    }
}