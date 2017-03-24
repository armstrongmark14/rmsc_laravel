<?php

use App\Model\Volunteer\Note;
use Illuminate\Database\Seeder;

class NotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Note::create(['value' => 'default']);
        Note::create(['value' => 'Mark is the best!']);
    }
}
