<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use App\Models\TicketHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $myTickets = $user->createdTickets()->count();
        $openTickets = $user->createdTickets()->where('status', 'open')->count();
        $inProgressTickets = $user->createdTickets()->where('status', 'in_progress')->count();
        $resolvedTickets = $user->createdTickets()->where('status', 'resolved')->count();
        
        $tickets = $user->createdTickets()
            ->with(['category', 'assignedAgent'])
            ->latest()
            ->take(10)
            ->get();

        return view('user.dashboard', compact(
            'myTickets', 
            'openTickets', 
            'inProgressTickets', 
            'resolvedTickets', 
            'tickets'
        ));
    }

    public function createTicket()
    {
        $categories = Category::orderBy('name')->get();

        return view('user.create-ticket', compact('categories'));
    }

    public function storeTicket(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:10|max:255',
            'description' => 'required|string|min:20',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:low,medium,high',
        ], [
            'title.min' => 'The title must be at least 10 characters.',
            'description.min' => 'Please provide a more detailed description (at least 20 characters).',
            'category_id.required' => 'Please select a category for your ticket.',
            'category_id.exists' => 'The selected category is not valid.',
        ]);

        $category = Category::find($request->category_id);
        
        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
            'status' => 'open',
            'created_by' => Auth::id(),
        ]);

        $availableAgents = $category->agents()
            ->where('isActive', 1)
            ->get();

        if ($availableAgents->isNotEmpty()) {
            $assignedAgent = $availableAgents->random();
            $ticket->update(['assigned_to' => $assignedAgent->id]);

            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'action_by' => Auth::id(),
                'old_status' => null,
                'new_status' => 'open',
                'remarks' => 'Ticket created and assigned to ' . $assignedAgent->name,
            ]);

            $message = "Ticket created successfully! It has been assigned to {$assignedAgent->name} for resolution.";
        } else {
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'action_by' => Auth::id(),
                'old_status' => null,
                'new_status' => 'open',
                'remarks' => 'Ticket created - no agents available for assignment',
            ]);

            $message = "Ticket created successfully! It will be assigned to an agent as soon as one becomes available.";
        }

        return redirect()->route('user.dashboard')->with('success', $message);
    }
}