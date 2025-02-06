<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use Notifiable;
    
    protected $fillable = ['email', 'password'];
    
    protected $hidden = ['password']; // Hide password for security
}
