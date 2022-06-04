<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatabaseInfo extends Model
{
    protected $fillable = [
        'user_id','db_name', 'db_password'
    ];
    use HasFactory;
}
