<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Member extends Model
{
    use HasFactory;
    
    protected $fillable = ['photo', 'name', 'age', 'email', 'phone'];
}
