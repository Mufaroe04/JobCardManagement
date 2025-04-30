<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'client_name',
        'job_description',
        'assigned_technician',
        'estimated_completion_date',
        'status',
        'admin_comments'
    ];
}
