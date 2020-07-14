<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    public function packages ()
    {
        return $this->hasMany(EstimatePackage::class, 'estimateId');
    }
}
