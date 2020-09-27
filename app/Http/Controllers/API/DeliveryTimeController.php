<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\DeliveryTime;
use App\Http\Requests\StoreDeliveryTimeRequest;

class DeliveryTimeController extends Controller
{
    public function store(StoreDeliveryTimeRequest $request){
        $deliveryTime = DeliveryTime::create([
            'delivery_at' => $request['delivery_at']
        ]);

        return response()->json('success');
    }
}
