<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function show(Ticket $ticket)
    {
        $ticket->load(['creator', 'assignedAgent', 'category', 'histories.actionBy']);
        
        $user = Auth::user();
        if (!$user->isSuperAdmin() && 
            $ticket->created_by !== $user->id && 
            $ticket->assigned_to !== $user->id) {
            abort(403);
        }

        return view('tickets.show', compact('ticket'));
    }
}