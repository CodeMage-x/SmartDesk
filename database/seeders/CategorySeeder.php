<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hardware Issues',
                'description' => 'Computer hardware problems, printer issues, device malfunctions'
            ],
            [
                'name' => 'Software Issues', 
                'description' => 'Application errors, software installation, license problems'
            ],
            [
                'name' => 'Network Problems',
                'description' => 'Internet connectivity, WiFi issues, VPN problems'
            ],
            [
                'name' => 'Account Access',
                'description' => 'Login issues, password resets, account lockouts'
            ],
            [
                'name' => 'Email Issues',
                'description' => 'Email configuration, delivery problems, Outlook issues'
            ],
            [
                'name' => 'Security Issues',
                'description' => 'Virus removal, security alerts, suspicious activities'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}