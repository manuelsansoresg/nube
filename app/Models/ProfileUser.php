<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    use HasFactory;
    protected $table = 'profile_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['heart', 'cont_corazones'];
}
