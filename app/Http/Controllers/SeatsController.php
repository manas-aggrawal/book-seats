<?php

namespace App\Http\Controllers;

use App\Models\Seats;
use Illuminate\Http\Request;

class SeatsController extends Controller
{
    private $seatsModel;
    /**
     * @return Seats
     */
    private function __getSeatsModel(){
        if($this->seatsModel===null){
            $this->seatsModel = new Seats();
        }
        return $this->seatsModel;
    }

    /**
     * Method to get all seats
     * @return View
     */
    public function DisplaySeats() {
        $seats = $this->__getSeatsModel()->DisplaySeats();
        return view('displaySeats')->with(compact('seats'));
    }

    /**
     * Method to book seats
     * @param Request $request
     * @return View
     */
    public function SelectSeats(Request $request) {
        
        $seats = $this->__getSeatsModel()->SelectSeats($request);
        return redirect()->back()->with(compact('seats'));
    }
}
