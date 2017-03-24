<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Seeding our volunteer table
        $this->call(VolunteerTableSeeder::class);
        $this->call(PhotosTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(TypeTableSeeder::class);
        $this->call(TimesheetTableSeeder::class);
        $this->call(NotesSeeder::class);
        $this->call(SkillsSeeder::class);
    }
}
