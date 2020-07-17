<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function vehicles ()
    {
        return $this->hasMany(CustomerVehicle::class, 'customerId');
    }

}
