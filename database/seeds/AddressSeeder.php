<?php

use App\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getAddress() as $key => $address) {
            Address::create(
              [
                'state_id' => $address['state_id'],
                'city_id' => $address['city_id'],
                'street' => $address['street'],
                'number' => $address['number'],
                'cep' => $address['cep']
              ]
            );
        }
    }

    public function getAddress()
    {
        $address = array(
            array(
                'state_id' => 19,
                'city_id' => 4,
                'street' => 'Maracana',
                'number' => 1000,
                'cep' => '14547-258'
            ),
            array(
                'state_id' => 25,
                'city_id' => 2,
                'street' => 'Rua das nações unidas',
                'number' => 600,
                'cep' => '13329-350'
            ),
            array(
                'state_id' => 25,
                'city_id' => 3,
                'street' => 'Estrada Itu',
                'number' => 6002,
                'cep' => '12345-487'
            ),
            array(
                'state_id' => 25,
                'city_id' => 2,
                'street' => 'Rua estado de alagoas',
                'number' => 546,
                'cep' => '13324-472'
            )
        );

        return $address;
    }
}
