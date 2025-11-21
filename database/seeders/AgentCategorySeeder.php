<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\AgentCategory;
use Illuminate\Database\Seeder;

class AgentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $hardwareCategory = $categories->where('name', 'Hardware Issues')->first();
        $softwareCategory = $categories->where('name', 'Software Issues')->first();
        $networkCategory = $categories->where('name', 'Network Problems')->first();
        $accountCategory = $categories->where('name', 'Account Access')->first();
        $emailCategory = $categories->where('name', 'Email Issues')->first();
        $securityCategory = $categories->where('name', 'Security Issues')->first();

        $agents = User::where('role', 'helpdesk_agent')->get();

        $agentSpecializations = [
            'john.smith@smartdesk.com' => [$hardwareCategory->id, $networkCategory->id], // Hardware & Network specialist
            'sarah.johnson@smartdesk.com' => [$softwareCategory->id, $emailCategory->id], // Software & Email specialist  
            'mike.chen@smartdesk.com' => [$securityCategory->id, $accountCategory->id], // Security & Account specialist
            'emily.davis@smartdesk.com' => [$hardwareCategory->id, $softwareCategory->id], // Hardware & Software specialist
            'robert.wilson@smartdesk.com' => [$networkCategory->id, $securityCategory->id] // Network & Security specialist
        ];

        foreach ($agents as $agent) {
            if (isset($agentSpecializations[$agent->email])) {
                foreach ($agentSpecializations[$agent->email] as $categoryId) {
                    AgentCategory::create([
                        'agent_id' => $agent->id,
                        'category_id' => $categoryId
                    ]);
                }
            }
        }
    }
}