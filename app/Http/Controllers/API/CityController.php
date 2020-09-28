<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\CityDeliveryTime;
use App\ExludedDates;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CityRequest;
use App\Http\Requests\AttachDeliveryTimesToCity;
use App\Http\Requests\ExcludeDateRequest;

class CityController extends Controller
{
    public function store(CityRequest $request)
    {
        $city = City::create([
            'name' => $request['name']
        ]);

        return response()->json('success');
    }

    public function attatchDeliveryTimes(AttachDeliveryTimesToCity $request, City $city)
    {
        if ($request->has('delivery_time')) {
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

    public function excludeDate(ExcludeDateRequest $request, City $city)
    {
        if ($request->has('delivery_time')) {
            $selectedCityDeliveryTime = CityDeliveryTime::where('city_id', $city->id)
                ->where('delivery_time_id', $request['delivery_time'])
                ->first();
            ExludedDates::create([
                    'date' => $request['date'],
                    'cityDeliveryTime_id' => $selectedCityDeliveryTime->id
                ]);
        } else {
            $selectedCityDeliveryTimes = CityDeliveryTime::where('city_id', $city->id)
                ->get();
            foreach ($selectedCityDeliveryTimes as $cityDeliveryTime) {
                ExludedDates::create([
                        'date' => $request['date'],
                        'cityDeliveryTime_id' => $cityDeliveryTime->id
                    ]);
            }
        }

        // foreach ($data as $value) {
        //     $excluding_dates = [];
        //     if ($value->excluding_dates != null) {
        //         $excluding_dates = json_decode($value->excluding_dates);
        //     }
        //     if (!in_array($request['date'], $excluding_dates)) {
        //         array_push($excluding_dates, $request['date']);
        //     }

        //     $value->excluding_dates = json_encode($excluding_dates);
        //     $value->save();
        // }

        return response()->json('Done');
    }
}
