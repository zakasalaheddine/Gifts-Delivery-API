<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'partner_id'];

    public function partner()
    {
        return $this->hasOne('App\Partner', 'partner_id');
    }

    public function deliveryTimes()
    {
        return $this->hasMany('App\CityDeliveryTime');
    }
}
