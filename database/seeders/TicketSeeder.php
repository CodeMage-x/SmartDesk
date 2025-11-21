<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\AgentCategory;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $endUsers = User::where('role', 'end_user')->get();
        $categories = Category::all();

        $sampleTickets = [
            [
                'title' => 'Printer not working',
                'description' => 'Office printer HP LaserJet is not responding. Shows error message "Paper Jam" but no paper is stuck.',
                'priority' => 'medium',
                'status' => 'open'
            ],
            [
                'title' => 'Cannot access email',
                'description' => 'Getting authentication error when trying to login to Outlook. Password was changed last week.',
                'priority' => 'high',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Software installation request',
                'description' => 'Need Adobe Photoshop installed for graphic design work. Please provide license and installation support.',
                'priority' => 'low',
                'status' => 'open'
            ],
            [
                'title' => 'WiFi connection issues',
                'description' => 'Internet connection keeps dropping every few minutes. Affecting work productivity.',
                'priority' => 'high',
                'status' => 'resolved'
            ],
            [
                'title' => 'Forgot password',
                'description' => 'Cannot remember login password for company portal. Need immediate reset.',
                'priority' => 'medium',
                'status' => 'closed'
            ]
        ];

        foreach ($sampleTickets as $index => $ticketData) {
            $randomUser = $endUsers->random();
            $randomCategory = $categories->random();
            
            $agentIds = AgentCategory::where('category_id', $randomCategory->id)
                ->pluck('agent_id')
                ->toArray();
            $assignedTo = !empty($agentIds) ? $agentIds[array_rand($agentIds)] : null;

            $ticket = Ticket::create([
                'title' => $ticketData['title'],
                'description' => $ticketData['description'],
                'category_id' => $randomCategory->id,
                'priority' => $ticketData['priority'],
                'status' => $ticketData['status'],
                'created_by' => $randomUser->id,
                'assigned_to' => $assignedTo,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 5))
            ]);

            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'action_by' => $randomUser->id,
                'new_status' => 'open',
                'remarks' => 'Ticket created',
                'created_at' => $ticket->created_at
            ]);

            if ($ticket->status !== 'open') {
                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'action_by' => $assignedTo,
                    'old_status' => 'open',
                    'new_status' => $ticket->status,
                    'remarks' => 'Status updated by agent',
                    'created_at' => $ticket->updated_at
                ]);
            }
        }
    }
}