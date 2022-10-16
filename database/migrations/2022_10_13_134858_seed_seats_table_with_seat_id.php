<?php

use Carbon\Carbon;
use App\Models\Seats;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Seats::truncate();
  
        $csvFile = fopen(base_path("database/data/book_seats.csv"), "r");
  
        
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            
                Seats::create([
                    "seat_id" => $data['1'],
                    "created_at" => Carbon::now(),
                ]);    
            
            
        }
   
        fclose($csvFile);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
