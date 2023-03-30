<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    //
    public function index()
    {
        $address = DB::table('address')->get();
        return view('home', compact('address'));
    }
    public function about()
    {
        return view('about');
    }
    public function accessdenied()
    {
        return view('accessdenied');
    }
}
