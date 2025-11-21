<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'created_by',
        'assigned_to',
        'status',
        'priority',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function histories()
    {
        return $this->hasMany(TicketHistory::class);
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'open' => 'bg-warning text-dark',
            'in_progress' => 'bg-info text-white',
            'resolved' => 'bg-success text-white',
            'closed' => 'bg-secondary text-white',
            default => 'bg-secondary text-white'
        };
    }

    public function getPriorityBadgeClass()
    {
        return match($this->priority) {
            'low' => 'bg-success text-white',
            'medium' => 'bg-warning text-dark',
            'high' => 'bg-danger text-white',
            default => 'bg-secondary text-white'
        };
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'open' => 'Open',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            'closed' => 'Closed',
            default => 'Unknown'
        };
    }

    public function getPriorityLabel()
    {
        return match($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            default => 'Unknown'
        };
    }

    public function canBeUpdated()
    {
        return in_array($this->status, ['open', 'in_progress']);
    }

    public function isClosed()
    {
        return in_array($this->status, ['resolved', 'closed']);
    }
}