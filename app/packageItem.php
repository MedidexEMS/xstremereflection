<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class packageItem extends Model
{
    public function desc()
    {
        return $this->belongsTo(Services::class, 'serviceId');
    }
}
