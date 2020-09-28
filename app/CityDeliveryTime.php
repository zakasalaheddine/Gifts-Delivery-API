<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityDeliveryTime extends Model
{
    protected $fillable = ['city_id', 'delivery_time_id', 'excluding_dates'];

    public function deliveryTime()
    {
        return $this->belongsTo('App\DeliveryTime');
    }
}
