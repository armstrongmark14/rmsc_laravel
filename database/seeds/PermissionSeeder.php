<?php

use App\Model\Admin\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Permission::create([
            'level' => 1,
            'name' => 'Basic User'
        ]);

        Permission::create([
            'level' => 1337,
            'name' => 'Super Admin'
        ]);
    }
}
