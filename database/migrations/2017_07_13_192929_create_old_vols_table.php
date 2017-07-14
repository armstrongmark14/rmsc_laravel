<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOldVolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*
         *
         *
         *
         *
         * NOT USING THIS TO CREATE IT, IMPORTING THIS TABLE FROM PREVIOUS SQL
         * This is a basic layout of what the table would be, but it might not work perfectly
         * since I'm importing the table not creating it using this. This is only here because it
         * might be needed at some point and then I can modify it to work if it doesn't.
         *
         * We shouldn't need this file at all.
         *
         *
         *
         *
         *
         *
         */
        Schema::create('old_vols', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('badge')->unsigned()->unique()->index();
            $table->string('department', 50)->nullable();
            // Creating the volunteer data
            $table->string('first_name', 50);
            $table->string('last_name', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip', 5)->nullable();
            $table->string('emerg_name')->nullable();
            $table->string('emerg_phone', 20)->nullable();
            $table->string('supervisor', 100)->nullable();
            $table->string('age', 50);
            $table->string('interests')->nullable();
            $table->string('skills')->nullable();
            $table->string('comments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('old_vols');
    }
}
