<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 1 consistent user
        User::create([
            'userNumber' => 1,
            'userEmail'=> 'rein.harle@han.nl',
            'userName' => 'rein',
            'userAddress1' => 'Ruitenberglaan 26',
            'userAddress2' => 'Arnhem',
            'userPostCode' => '6826 CC',
            'userCountry' =>'Nederland',
            'userBirthDate'	=> '1900-01-01',
            'userStatus' => 2
        ]);

        // Create random users
        factory(App\User::class, 50)->create();

    }
}
