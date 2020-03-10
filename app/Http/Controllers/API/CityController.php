<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\CityDeliveryTime;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cities|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json('Error! Fails to process the request');
        }
        City::create([
            'name' => $request['name']
        ]);

        return response()->json('success');
    }

    public function attatchDeliveryTimes(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), [
            'delivery_time' => 'integer',
            'delivery_times' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json('Error! Fails to process the request');
        }

        if ($request->has('delivery_time')) {

            $exist = CityDeliveryTime::where('city_id', $city->id)
                ->where('delivery_time_id', $request['delivery_time'])
                ->first();

            if ($exist != null) {
                return response()->json('Error! Already Attached');
            }

            CityDeliveryTime::create([
                'city_id' => $city->id,
                'delivery_time_id' => $request['delivery_time']
            ]);

            return response()->json('success');
        }

        if ($request->has('delivery_times')) {

            foreach ($request['delivery_times'] as $deliveryTime) {
                $exist = CityDeliveryTime::where('city_id', $city->id)
                    ->where('delivery_time_id', $deliveryTime)
                    ->first();

                if ($exist == null) {
                    CityDeliveryTime::create([
                        'city_id' => $city->id,
                        'delivery_time_id' => $deliveryTime
                    ]);
                }
            }
            return response()->json('success');
        }
    }

    public function excludeDate(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|max:50|date',
            'delivery_time' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json('Error! Fails to process the request');
        }
        $data = null;
        if ($request->has('delivery_time')) {
            $data = CityDeliveryTime::where('city_id', $city->id)
                ->where('delivery_time_id', $request['delivery_time'])
                ->get();
        } else {
            $data = CityDeliveryTime::where('city_id', $city->id)
                ->get();
        }

        if ($data == null) {
            return response()->json('Error! City not found');
        }

        foreach ($data as $value) {
            $excluding_dates = [];
            if ($value->excluding_dates != null) {
                $excluding_dates = json_decode($value->excluding_dates);
            }
            if (!in_array($request['date'], $excluding_dates)) {
                array_push($excluding_dates, $request['date']);
            }

            $value->excluding_dates = json_encode($excluding_dates);
            $value->save();
        }

        return response()->json('Done');
    }
}
