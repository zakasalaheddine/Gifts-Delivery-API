<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExludedDates extends Model
{
    protected $fillable = ['date', 'cityDeliveryTime_id'];
}
