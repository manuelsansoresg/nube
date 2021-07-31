<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TagTitle;
use Illuminate\Http\Request;

class ATagTitle extends Controller
{
    public function show($search, Request $request)
    {
        
        $get_titles = TagTitle::listTitleTag( $search , $request->page, $request->user_id);
        $data = array('total_titles' => count($get_titles), 'titles' => $get_titles);
        return $data;
    }
}
