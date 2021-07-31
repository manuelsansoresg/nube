<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\TitleUser;
use Illuminate\Http\Request;

class APaymentController extends Controller
{
    public function index(PaymentRequest $request)
    {
        $title_user = TitleUser::saveTitle($request);
        return response()->json($title_user);
        
    }
}
