<?php

use Illuminate\Database\Seeder;

use App\Roles;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role_name = array("admin", "edit", "view");
        foreach(range(1,3) as $index)
        {
        	Roles::create([
        		'name' => $role_name[--$index]
        	]);
        }

    }
}
