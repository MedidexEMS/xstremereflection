<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    public function estimate ()
    {
        return $this->belongsTo(Estimate::class, 'estimateId');
    }
}
