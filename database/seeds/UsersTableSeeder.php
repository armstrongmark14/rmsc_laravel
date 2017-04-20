<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $newUser = [
            'name' => 'Mark Armstrong',
            'email' => 'rmsc@rmsc.org',
            'password' => Hash::make('mitb'),
            'permission_id' => '2'
        ];

        User::create($newUser);

        $newUser = [
            'name' => 'test',
            'email' => 'rmsc@rmsc.org',
            'password' => Hash::make('test'),
            'permission_id' => '1'
        ];

        User::create($newUser);
    }
}
