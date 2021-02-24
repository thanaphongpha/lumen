<?php

namespace App\Console\Commands;

use App\Models\Time;
use Illuminate\Console\Command;

class AutoCheckOut extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:autocheckout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $employee_id = 4;
        $thisTime = date('H:i:s');
        $thisDate = date('Y-m-d');
        //$time = Time::whereDate('start_date', '=', $thisDate)->where('user_id', '=', $employee_id)->first();
        $timearr = Time::whereDate('start_date', '=', $thisDate)->get();

        $lenght = count($timearr);

        if($timearr->isNotEmpty()){
            foreach ($timearr as $key => $item ) {
                $item->end_time = $thisTime;
                $item->end_date = $thisDate;
                $item->save();
            }
        }



//        $time->end_time = $thisTime;
//        $time->end_date = $thisDate;
//        //$time->created_at = $checkInTime;
//        $time->save();
    }
}
