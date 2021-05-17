<?php

use App\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getCities() as $key => $city) {
            City::create(
              [
                'state_id' => $city['state_id'],
                'name' => $city['name']
              ]
            );
        }
    }

    public function getCities()
    {
        $cities = array(
            array(
                'state_id' => 25,
                'name' => 'São Paulo'
            ),
            array(
                'state_id' => 25,
                'name' => 'Salto'
            ),
            array(
                'state_id' => 25,
                'name' => 'Itu'
            ),
            array(
                'state_id' => 19,
                'name' => 'Rio de Janeiro'
            ),
            array(
                'state_id' => 13,
                'name' => 'Belo Horizonte'
            ),
            array(
                'state_id' => 13,
                'name' => 'Montes Claros'
            )
        );

        return $cities;
    }
}
