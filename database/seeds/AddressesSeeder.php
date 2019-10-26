<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Address;
use App\Province;
use App\Regency;

class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::populate();
        Regency::populate();

        $customer = User::where('email', 'customer@gmail.com')->first();
        $address1 = Address::create([
            'user_id' => $customer->id,
            'name' => 'Via Vallen',
            'detail' => 'Desa Kalitengah, Tanggulangin RT 1 R2 2',
            'regency_id' => 409,
            'phone' => '81098765432',
        ]);

        $address2 = Address::create([
            'user_id' => $customer->id,
            'name' => 'Chelsea Islan',
            'detail' => 'Gedangsari, Tamansari RT 3 RW 4',
            'regency_id' => 135,
            'phone' => '81234567890',
        ]);
    }
}
