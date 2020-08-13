<?php

namespace Vanguard\Console\Commands;

use Illuminate\Console\Command;
use Vanguard\WorkOrder;
use Illuminate\Support\Facades\Mail;
use Vanguard\Mail\CompletedWorkOrder;

class WorkOrderCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workorder:completed';

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
        $workOrder = WorkOrder::
            with('estimate', 'estimate.customer', 'estimate.customer.vehicleInfo')
            ->where('status', 8)->get();

        foreach ($workOrder as $wo)
        {
            if($wo->estimate->customer->email)
            {
                Mail::to(['jblevins@xtremereflection.app'])->send(new CompletedWorkOrder($wo));

                $wo->completionEmail = 1;
                $wo->save();

            }
        }
    }
}
