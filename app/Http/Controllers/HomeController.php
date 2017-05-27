<?php

namespace MadHunt\Http\Controllers;

use MadHunt\madhuntData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function saveData(Request $request){
        madhuntData::create([
            'lat' => $request->lat,
            'lng' => $request->lng,
            'radius' => $request->radius,
            'user' => Auth::id()
        ]);

        return response()->json(array('msg'=> "Data submitted successfully!"), 200);
    }
}
