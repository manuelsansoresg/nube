<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FollowersComponent extends Component
{

    public $myFollowers;
    public $path;
    public $my_user_id;

    public function mount($followers, $path , $my_user_id)
    {
        $this->myFollowers = number_format_short($followers);
        $this->path        = $path;
        $this->my_user_id  = $my_user_id;
    }

    public function render()
    {
        return view('livewire.followers-component');
    }
}
