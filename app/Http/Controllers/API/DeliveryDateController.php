<?php

namespace App\Http\Controllers\API;

use App\City;
use App\CityDeliveryTime;
use App\DeliveryTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DeliveryDateController extends Controller
{
    public function getDeliveryDateTimes(Request $request, City $city, $days)
    {
        $cityDeliveryTimes = CityDeliveryTime::where('city_id', $city->id)
            ->get();
        $deliveryTimes = DeliveryTime::whereIn('id', $cityDeliveryTimes->pluck(['delivery_time_id']))
            ->get();

        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $date = Carbon::now()->addDay($i);
            $validIds = [];
            foreach ($cityDeliveryTimes as $value) {
                if ($value->excluding_dates != null && !in_array($date->format("d-m-yy"), json_decode($value->excluding_dates))) {
                    array_push($validIds, $value->delivery_time_id);
                }
            }
            $results = $deliveryTimes->whereIn('id', $validIds);
            array_push($data, [
                'day_name' => $date->englishDayOfWeek,
                'date' => $date->format("d-m-yy"),
                'delivery_times' => $results,
            ]);
        }
        // return response()->json($deliveryTimes);
        return response()->json(['dates' => $data]);
    }
}
