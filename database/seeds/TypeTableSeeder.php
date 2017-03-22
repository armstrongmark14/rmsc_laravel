<?php

use Illuminate\Database\Seeder;
use App\Model\Volunteer\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Type::create(['name' => 'Volunteer']);
        Type::create(['name' => 'Intern']);
        Type::create(['name' => 'Docent']);

    }
}
