<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friend extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_freind_id',
        'second_freind_id'
    ];
}
