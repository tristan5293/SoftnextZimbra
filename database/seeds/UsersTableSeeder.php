<?php

use Illuminate\Database\Seeder;

use App\Users;
use App\UserRoles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create admin account, role:admin, edit, view
        $user = Users::create([
            		'account' => 'admin',
            		'password' => Hash::make('8888'),
                'last_login' => '2017-03-07 15:00:00',
                'last_logout' => '2017-03-07 15:10:00',
        		]);
        UserRoles::create(array('users_id' => $user->id, 'roles_id' => 1));
        UserRoles::create(array('users_id' => $user->id, 'roles_id' => 2));
        UserRoles::create(array('users_id' => $user->id, 'roles_id' => 3));

        //create jeff account, role:view
        $user = Users::create([
                    'account' => 'jeff',
                    'password' => Hash::make('jeff1986'),
                    'last_login' => '2017-03-07 15:00:00',
                    'last_logout' => '2017-03-07 15:10:00',
                ]);
        UserRoles::create(array('users_id' => $user->id, 'roles_id' => 3));
    }
}
