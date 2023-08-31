<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class massage extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'sender_id',
        'receiver_id',
        'receiver_type'
    ];
    
}
