<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'type',
        'title',
        'effort',
        'description',
        'status',
        'acceptance_criteria',
        'assignee_id',
        'reporter_id',
        'priority'
    ];
}
