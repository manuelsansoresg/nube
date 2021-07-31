<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddHeartRequest;
use App\Models\TitleUser;
use Illuminate\Http\Request;

class ATitleUserController extends Controller
{
    public function storeHeart($title_id, AddHeartRequest $request)
    {
        
        $add_hearts = TitleUser::addHeart($title_id, $request-> icorazones);
        return response()->json($add_hearts);
    }
}
