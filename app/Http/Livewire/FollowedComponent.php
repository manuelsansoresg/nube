<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FollowedComponent extends Component
{

    public $followed;
    public $path;
    public $my_user_id;
    public $myFollowed;

    public function mount($followed, $path, $my_user_id)
    {
        $this->myFollowed = number_format_short($followed);
        $this->path       = $path;
        $this->my_user_id = $my_user_id;
    }

    public function render()
    {
        return view('livewire.followed-component');
    }
}
