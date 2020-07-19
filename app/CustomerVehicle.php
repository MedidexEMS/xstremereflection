<?php

namespace Vanguard;

use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    public function color()
    {
        return $this->belongsTo(VehicleCondition::class, 'vehicleColor');
    }
    public function condition()
    {
        return $this->belongsTo(VehicleCondition::class, 'vehicleCondition');
    }
}
