<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\FcmToken;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->Firebase = new FirebaseController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $tokens = FcmToken::all()->pluck('fcm_token')->toArray();
        $data = [
            "title" => "Come From Database",
            "body" => 'Test Notification',
        ];
        $this->Firebase->send($tokens, $data);
        return view('home');
    }

}
