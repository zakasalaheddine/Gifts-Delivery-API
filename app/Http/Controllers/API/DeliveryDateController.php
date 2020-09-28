<?php

namespace App\Http\Controllers\API;

use App\City;
use App\CityDeliveryTime;
use App\DeliveryTime;
use App\ExludedDates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DeliveryDateController extends Controller
{
    public function getDeliveryDateTimes(Request $request, City $city, $days)
    {
        $cityDeliveryTimes = CityDeliveryTime::where('city_id', $city->id)
            ->get();
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $date = Carbon::now()->addDay($i);
            $exludedDates = ExludedDates::wherein('cityDeliveryTime_id', $cityDeliveryTimes
                    ->pluck(['delivery_time_id']))
                    ->where('date', $date->format("Y-m-d"))
                    ->get();
            $valideTimes = [];
            foreach ($cityDeliveryTimes as $cityDeliveryTime) {
                $currentExcludeDate = $exludedDates->where('cityDeliveryTime_id', $cityDeliveryTime->id)->first();
                if (!$currentExcludeDate) {
                    $valideTimes[] = [$cityDeliveryTime->deliveryTime];
                }
            }
            if (count($valideTimes) > 0) {
                $data[] = [
                    'day_name' => $date->englishDayOfWeek,
                    'date' => $date->format("d-m-yy"),
                    'delivery_times' => $valideTimes,
                ];
            }
        }
        return response()->json(['dates' => $data]);
    }
}
