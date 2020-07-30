<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    public function estimate ()
    {
        return $this->belongsTo(Estimate::class, 'estimateId');
    }

    public function services ()
    {
        return $this->hasMany(WorkOrderServices::class, 'workOrderId');
    }
}
