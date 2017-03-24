<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            // Creating all the foreign keys for these tables
            $table->integer('badge')->unsigned()->unique();
            $table->integer('department_id')->unsigned();
            $table->integer('photo_id')->unsigned()->default(1);
            $table->integer('type_id')->unsigned();

            // Creating the volunteer data
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->string('address');
            $table->string('city', 50);
            $table->string('state', 2);
            $table->string('zip', 5);
            $table->string('emergency_contact');
            $table->string('emergency_phone', 20);
            $table->string('supervisor', 100)->default('none');

            // Some last minute additions to the table
            $table->integer('note_id')->unsigned()->default(1);
            $table->integer('skill_id')->unsigned()->default(1);

            // The default created at/updated at timestamps
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
        Schema::dropIfExists('volunteers');
    }
}
