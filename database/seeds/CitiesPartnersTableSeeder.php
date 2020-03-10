<?php

use Illuminate\Database\Seeder;
use App\City;
use App\Partner;

class CitiesPartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = ['Rabat', 'Casa', 'Tangier'];
        $partners = ['Mohamed', 'Hassan', 'Nada'];

        for ($i = 0; $i < 3; $i++) {
            $city = City::create(['name' => $cities[$i]]);
            $partner = Partner::create(['name' =>  $partners[$i], 'city_id' => $city->id]);
            $city->partner_id = $partner->id;
            $city->save();
        }
    }
}
