<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateTown extends Model
{
    use HasFactory;
    static function get($state_id)
    {
        $state_town = StateTown::select( 'towns.name as name', 'towns.id as id')
                        ->join( 'towns' , 'towns.id' , '=' , 'state_town.town_id')
                        ->where( 'state_id' , $state_id)->get();
        
        return $state_town;
    }
    
}
