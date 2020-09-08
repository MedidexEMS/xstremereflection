<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'estimateId');
    }
}
