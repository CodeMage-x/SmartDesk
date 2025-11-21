<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\AgentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'open')->count();
        $resolvedTickets = Ticket::where('status', 'resolved')->count();
        
        $recentTickets = Ticket::with(['creator', 'category', 'assignedAgent'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalTickets', 
            'openTickets', 
            'resolvedTickets', 
            'recentTickets'
        ));
    }

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        $categories = Category::all();
        return view('admin.create-user', compact('categories'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:super_admin,helpdesk_agent,end_user',
            'categories' => 'required_if:role,helpdesk_agent|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'must_change_password' => true,
        ]);

        if ($request->role === 'helpdesk_agent' && $request->categories) {
            foreach ($request->categories as $categoryId) {
                AgentCategory::create([
                    'agent_id' => $user->id,
                    'category_id' => $categoryId,
                ]);
            }
        }

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['isActive' => !$user->isActive]);
        
        $status = $user->isActive ? 'activated' : 'deactivated';
        return redirect()->route('admin.users')->with('success', "User has been {$status}.");
    }

    public function reassignTicket(Request $request, Ticket $ticket)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $ticket->update(['assigned_to' => $request->agent_id]);

        return redirect()->back()->with('success', 'Ticket reassigned successfully.');
    }
   public function tickets()
    {
    $tickets = Ticket::with(['creator', 'category', 'assignedAgent'])
        ->latest()
        ->paginate(20);

    $totalTickets = Ticket::count();
    $unassignedTickets = Ticket::whereNull('assigned_to')->count();
    $inProgressTickets = Ticket::where('status', 'in_progress')->count();
    $resolvedTickets = Ticket::where('status', 'resolved')->count();

    return view('admin.tickets', compact(
        'tickets',
        'totalTickets',
        'unassignedTickets',
        'inProgressTickets',
        'resolvedTickets'
    ));
    }

   public function getAgentsByCategory(\App\Models\Category $category)
{
    $agents = \App\Models\User::query()
        ->select('users.id', 'users.name')
        ->where('users.role', 'helpdesk_agent')
        ->where('users.isActive', 1)
        ->whereExists(function ($q) use ($category) {
            $q->from('agent_categories')
              ->whereColumn('agent_categories.agent_id', 'users.id')
              ->where('agent_categories.category_id', $category->id);
        })
        ->orderBy('users.name')
        ->get();

    return response()->json($agents);
}
}