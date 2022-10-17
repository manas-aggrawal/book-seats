<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'seat_id', 'status'];


    /**
     * Method to get all seats
     * @return Array $seats
     */
    public function DisplaySeats()
    {
        $seats = Seats::select('seat_id', 'status')->get()->toArray();

        return $seats;
    }

    /**
     * Method to book seats
     * @param Request $request
     * @return Array $ret_seats
     */
    public function SelectSeats($request)
    {
        $num_of_seats_req = $request->input('num_of_seats_req');
        if($num_of_seats_req<=7){

        $all_seats = Seats::select('seat_id', 'status')->get()->toArray();
        $tot_av_seats = Seats::select('seat_id')->where('status', 1)->count();
        if ($num_of_seats_req <= $tot_av_seats) {

            $count = 0;
            $i = 0;
            $j = 0;
            $arr = [[]]; //2d array for seats in diff rows
            foreach ($all_seats as $seat) {

                ++$count;
                if ($count > 7) {
                    $count = 1;
                    ++$i;
                    $j = 0;
                }
                $arr[$i][$j] = $seat;
                ++$j;

            }

            $av_seats_in_rows = []; //array to keep count of total available seats in each row.
            $seat_count = 0;

            /************count available seats in each row and put them in "av_seats_in_rows" array************/
            foreach ($arr as $ar) {
                foreach ($ar as $a) {
                    if ($a['status'] == 1) {
                        ++$seat_count;
                    }

                }
                array_push($av_seats_in_rows, $seat_count);
                $seat_count = 0;
            }

            /***************Find which row can accomodate incoming request completely without wasting any space*************/
            $min = 10;
            $row = 0;
            $flag = -1;
            for ($i = 0; $i < count($av_seats_in_rows); $i++) {

                if ($av_seats_in_rows[$i] - $num_of_seats_req >= 0 && $av_seats_in_rows[$i] < $min) {
                    $min = $av_seats_in_rows[$i];
                    $row = $i;
                    $flag = 1;

                }
            }

            /*****************************Start Booking*****************************/
            $book_these = [];

            //booking those seats which come first when all seats are not available in one row
            if ($flag == -1) {
                $av_seat_id = Seats::where('status', 1)->limit($num_of_seats_req)->update(['status' => 0]);
            }
            //booking seats in one row
            else {
                for ($j = 0; $j < 7; $j++) {
                    if ($arr[$row][$j]['status'] == 1) {
                        array_push($book_these, $arr[$row][$j]['seat_id']);

                    }
                }
                Seats::whereIn('seat_id', $book_these)->limit($num_of_seats_req)->update(['status' => 0]);
            }

        }
        $ret_seats = Seats::select('seat_id', 'status')->get()->toArray();
        return $ret_seats;
    }else{
        return 0;
    }

    }
}
