<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\DeliveryTime;

class DeliveryTimeController extends Controller
{
    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'delivery_at' => 'required|unique:delivery_times|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json('Error! Fails to process the request');
        }

        DeliveryTime::create([
            'delivery_at' => $request['delivery_at']
        ]);

        return response()->json('success');
    }
}
