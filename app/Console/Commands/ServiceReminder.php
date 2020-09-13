<?php

namespace Vanguard\Console\Commands;

use Illuminate\Console\Command;
use Vanguard\Estimate;
use Carbon\Carbon;

class ServiceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:reminder';

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
     * @return int
     */
    public function handle()
    {
        $estimate= Estimate::whereDate('created_at', Carbon::today())->where('status', 4 )->get();

        //dd(count($estimate));

        foreach ($estimate as $row)
        {

            if($row->dateofService)
            {
                $start = $row->dateofService;
                $now = Carbon::now();

                $date1 = new DateTime($start);
                $date2 = new DateTime($now);
                $interval = $date1->diff($now);
                $days = $interval->format('%a');
                if($days == $row->maint )
                {
                    $newEstimate = new Estimate;
                    $newEstimate->companyId = $row->companyId;
                    $newEstimate->detailType = $row->detailType;
                    $newEstimate->customerId = $row->customerId;
                    $newEstimate->status = 1;
                    $newEstimate->problem = 'Customer vehicle due for maintenance.';
                    $newEstimate->save();
                }

            }

        }

        return 0;
    }
}
