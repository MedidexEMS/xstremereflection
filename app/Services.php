<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    public function package ()
    {
        return $this->belongsTo(Package::class, 'serviceId');
    }
}
