<?php

use Illuminate\Database\Seeder;
use App\Model\Volunteer\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Department::create(['name' => 'Education']);
        Department::create(['name' => 'Advancement']);
        Department::create(['name' => 'Collections']);
        Department::create(['name' => 'Technical Advisory Group']);


    }
}
