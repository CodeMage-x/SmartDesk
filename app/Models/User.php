<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'isActive',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'isActive' => 'boolean',
            'must_change_password' => 'boolean',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isHelpdeskAgent(): bool
    {
        return $this->role === 'helpdesk_agent';
    }

    public function isEndUser(): bool
    {
        return $this->role === 'end_user';
    }

    public function createdTickets()
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function agentCategories()
    {
        return $this->hasMany(AgentCategory::class, 'agent_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'agent_categories', 'agent_id', 'category_id');
    }

    public function ticketHistories()
    {
        return $this->hasMany(TicketHistory::class, 'action_by');
    }
}