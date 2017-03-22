<?php

use App\Model\Volunteer\Volunteer;
use Illuminate\Database\Seeder;

class VolunteerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // This will fill our volunteer database with 2 entries, Mark and Liz
        Volunteer::create([
            'badge' => '1',
            'department_id' => '1',
            'photo_id' => '1',
            'type_id' => '1',

            'first_name' => 'Mark',
            'last_name' => 'Armstrong',
            'email' => 'armstrongmark14@gmail.com',
            'phone' => '123-456-7890',
            'address' => '51 Lynnwood Drive',
            'city' => 'Rochester',
            'state' => 'NY',
            'zip' => '14618',
            'emergency_contact' => 'Mom',
            'emergency_phone' => '555-555-5555'
        ]);

        Volunteer::create([
            'badge' => '2',
            'department_id' => '3',
            'photo_id' => '1',
            'type_id' => '4',

            'first_name' => 'Liz',
            'last_name' => 'Albertorio',
            'email' => 'liz@gmail.com',
            'phone' => '111-111-1111',
            'address' => '100 Street Road',
            'city' => 'Rochester',
            'state' => 'NY',
            'zip' => '14618',
            'emergency_contact' => 'Donald Trump',
            'emergency_phone' => '555-555-5555'
        ]);
    }
}
