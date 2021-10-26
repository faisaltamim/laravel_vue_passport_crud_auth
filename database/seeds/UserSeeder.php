<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    public function run() {
        foreach ( range( 1, 5 ) as $index ) {
            User::create( [
                'name'     => 'Faisal Tamim' . mt_rand( 10, 9999 ),
                'phone'     => '0187571' . mt_rand(1000,9999),
                'email'    => 'ft' . mt_rand( 10, 9999 ) . '@gmail.com',
                'password' => Hash::make( '12345678' ),
            ] );
        }
    }

}
