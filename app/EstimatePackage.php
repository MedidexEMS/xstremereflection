<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class EstimatePackage extends Model
{
    public function package ()
    {
        return $this->belongsTo(Package::class, 'packageId');
    }
}
