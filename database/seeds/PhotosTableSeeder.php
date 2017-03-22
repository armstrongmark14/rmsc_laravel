<?php

use Illuminate\Database\Seeder;
use App\Model\Volunteer\Photo;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Photo::create(['filename' => 'default.png']);
        Photo::create(['filename' => 'mark.png']);
        Photo::create(['filename' => 'liz.png']);

    }
}
