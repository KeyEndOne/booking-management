<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function home()
    {
        return view('admin.home');
    }
    public function address()
    {
        $address = DB::table('address')->get();   
        return view('admin.address', compact('address'));
    }
    public function createaddress(Request $request)
    {

        $name = $request->AddressName;

        $words = explode(" ", $name);
        $code = "";

        foreach ($words as $w) {
            $code .= mb_substr($w, 0, 1);
        }

        DB::table('address')->insert([
            'AddressId' => $code,
            'AddressName' => $name,
        ]);

        return response()->json(array('success' => true));
    }

    public function editaddress(Request $request)
    {
        $code = $request->AddressId;
        $name = $request->AddressName;

        DB::table('address')
        ->where('AddressId', $code)
        ->update(['AddressName' => $name]);
        return response()->json(array('success' => true));
    }

    public function deladdress(Request $request)
    {
        $code = $request->AddressId;
        DB::table('address')->where('AddressId', $code)->delete();

        return response()->json(array('success' => true));
    }

    public function tour()
    {
        $address = DB::table('address')->get();   
        $tour = DB::table('tour')
        ->select('tour.TourId', 'f.AddressName as FromAddress', 't.AddressName as ToAddress', 'FromHour', 'Seat', 'ToHour', 'Price')
        ->join('address as f', 'f.AddressId', '=', 'tour.FromAddress')
        ->join('address as t', 't.AddressId', '=', 'tour.ToAddress')
        ->get();
        return view('admin.tour',compact('tour','address'));
    }


    public function createtour(Request $request)
    {
        $FromAddress = $request->FromAddress;
        $ToAddress = $request->ToAddress;
        $FromHour = $request->FromHour;
        $ToHour = $request->ToHour;
        $Price = $request->Price;
        $Seat = $request->Seat;

        //get tourId
        $statement = DB::select("SHOW TABLE STATUS LIKE 'tour'");
        $nextId = $statement[0]->Auto_increment;
       
        //create tour
        DB::table('tour')->insertGetId([
            'FromAddress' => $FromAddress,
            'FromHour' => $FromHour,
            'ToHour' => $ToHour,
            'ToAddress' => $ToAddress,
            'Price' => $Price,
            'Seat' => $Seat,
        ]);
       
        //create seat
        for ($i=1; $i <= $Seat; $i++) { 
            DB::table('tourseat')->insert([
                'TourId' => $nextId,
                'SeatId' => $i,
                'Status' =>"Empty",
            ]);
        }
        return response()->json(array('success' => true));
    }
    public function edittour()
    {
        return response()->json(array('success' => true));
    }
    public function deltour(Request $request)
    {
        $tourId = $request->TourId;
        DB::table('tour')->where('TourId', $tourId)->delete();
        DB::table('tourseat')->where('TourId', $tourId)->delete();

        return response()->json(array('success' => true));
    }
    public function user()
    {
        $user = DB::table('users')->get();
        return view(('admin.user'),compact('user'));
    }
    public function deluser(Request $request)
    {
        DB::table('users')->where('id',$request->id)->delete();
        return response()->json(array('success' => true));
    }
}
