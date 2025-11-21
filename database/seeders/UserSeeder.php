<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@smartdesk.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'isActive' => 1,
            'email_verified_at' => now(),
        ]);

        // Create Helpdesk Agents
        $agents = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@smartdesk.com',
                'password' => Hash::make('agent123'),
                'role' => 'helpdesk_agent',
                'isActive' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@smartdesk.com', 
                'password' => Hash::make('agent123'),
                'role' => 'helpdesk_agent',
                'isActive' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mike Chen',
                'email' => 'mike.chen@smartdesk.com',
                'password' => Hash::make('agent123'),
                'role' => 'helpdesk_agent',
                'isActive' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@smartdesk.com',
                'password' => Hash::make('agent123'),
                'role' => 'helpdesk_agent',
                'isActive' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'robert.wilson@smartdesk.com',
                'password' => Hash::make('agent123'),
                'role' => 'helpdesk_agent',
                'isActive' => 1,
                'email_verified_at' => now(),
            ]
        ];

        foreach ($agents as $agent) {
            User::create($agent);
        }

        // Create End Users
        $endUsers = [
            [
                'name' => 'Alice Brown',
                'email' => 'alice.brown@company.com',
                'password' => Hash::make('user123'),
                'role' => 'end_user',
                'isActive' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'David Miller',
                'email' => 'david.miller@company.com',
                'password' => Hash::make('user123'),
                'role' => 'end_user',
                'isActive' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Lisa Garcia',
                'email' => 'lisa.garcia@company.com',
                'password' => Hash::make('user123'),
                'role' => 'end_user',
                'isActive' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Tom Anderson',
                'email' => 'tom.anderson@company.com',
                'password' => Hash::make('user123'),
                'role' => 'end_user',
                'isActive' => 1,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jennifer Lee',
                'email' => 'jennifer.lee@company.com',
                'password' => Hash::make('user123'),
                'role' => 'end_user',
                'isActive' => 1,
                'email_verified_at' => now(),
            ]
        ];

        foreach ($endUsers as $user) {
            User::create($user);
        }
    }
}