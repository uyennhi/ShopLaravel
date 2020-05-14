<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    //
    public function index(){
        $countries=DB::table('countries')->get();
        $user_login=User::where('id',Auth::id())->first();
        return view('checkout.index',compact('countries','user_login'));
    }
}
