<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\{UserService};

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view("home",[
           "address"    => \request()->user()?->address?->address,
           "no_int"     => \request()->user()?->address?->no_int ,
           "no_ext"     => \request()->user()?->address?->no_ext ,
           "cp"         => \request()->user()?->address?->cp     ,
           "state"      => \request()->user()?->address?->state  ,
           "city"       => \request()->user()?->address?->city   ,
           "colony"     => \request()->user()?->address?->colony ,
           "status"     => \request()->user()?->address?->status ,
        ]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewRegisters()
    {
        return view('register',[
            "name"          => \request()->user()->name,
            "last_name"     => \request()->user()->last_name,
            "second_name"   => \request()->user()->second_name,
            "phone"         => \request()->user()->phone,
            "email"         => \request()->user()->email,
        ]);
    }

    public function storeRegisterUser()
    {
        $response = (new UserService())->saveRepository(\request()->except(["_token"]));

        return view("home",[
           "address"    => \request()->user()?->address?->address,
           "no_int"     => \request()->user()?->address?->no_int ,
           "no_ext"     => \request()->user()?->address?->no_ext ,
           "cp"         => \request()->user()?->address?->cp     ,
           "state"      => \request()->user()?->address?->state  ,
           "city"       => \request()->user()?->address?->city   ,
           "colony"     => \request()->user()?->address?->colony ,
           "status"     => \request()->user()?->address?->status ,
        ]);

    }

}
