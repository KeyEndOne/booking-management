<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TicketController extends Controller
{
    //
    public function index()
    {
        $address = DB::table('address')->get();
        return view('search', compact('address'));
    }

    public function searchtour(Request $request)
    {
        
        $tour = DB::table('tour')
            ->select('tour.TourId', 'f.AddressName as FromAddress', 't.AddressName as ToAddress', 'FromHour', 'Seat', 'ToHour', 'Price')
            ->join('address as f', 'f.AddressId', '=', 'tour.FromAddress')
            ->join('address as t', 't.AddressId', '=', 'tour.ToAddress')
            ->where('f.AddressId', $request->fromAddress)
            ->where('t.AddressId', $request->toAddress)
            ->where('FromHour', '>=', $request->date)
            ->get();


        return view('search', compact('tour'));
    }
    
    public function createticket(Request $request)
    {
        $userName = Auth::user()->name;
        $tourId = $request->tourId;
        foreach (\explode(',', $request->lstSeat) as $s) {

            //add ticket
            DB::table('ticket')->insertGetId(
                array('TourId' => $tourId, 'SeatId' => $s,'UserName' => $userName)
            );

            //change status seat
            DB::table('tourseat')
                ->where('SeatId', $s)
                ->where('TourId', $tourId)
                ->update(['Status' => "Booked"]);
        }

        return response()->json(array('success' => true));
    }

    public function searchtiket()
    {
        $userName = Auth::user()->name;
        $ticket = DB::table('ticket')
        ->select('TicketId','tour.FromHour','tour.ToHour','f.AddressName as FromAddress', 't.AddressName as ToAddress','tour.Price','ticket.SeatId')
        ->join('tour', 'tour.TourId', '=', 'ticket.TourId')
        ->join('address as f', 'f.AddressId', '=', 'tour.FromAddress')
        ->join('address as t', 't.AddressId', '=', 'tour.ToAddress')
        ->where('UserName', $userName)
        ->get();
        return view('myticket', compact('ticket'));
    }

    public function delticket(Request $request)
    {
        $TicketId = $request->ticketId;

        //get ticket
        $ticket = DB::table('ticket')->select('TourId','SeatId')->where('TicketId',$TicketId)->first();
        $SeatId = $ticket->SeatId;
        $TourId = $ticket->TourId;

        //delete ticket
        DB::table('ticket')
            ->where('TicketId',$TicketId)
            ->delete();
        // change status seat
        DB::table('tourseat')
        ->where('SeatId', $SeatId)
        ->where('TourId', $TourId)
        ->update(['Status' => "Empty"]);
        return response()->json(array('success' => true ));
    }
    public function ticketok()
    {
        return view('ticketok');
    }
}
