<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function agentCategories()
    {
        return $this->hasMany(AgentCategory::class);
    }

    public function agents()
    {
        return $this->belongsToMany(User::class, 'agent_categories', 'category_id', 'agent_id');
    }
}