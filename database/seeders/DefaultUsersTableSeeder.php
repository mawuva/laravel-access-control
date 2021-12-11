<?php

namespace Mawuekom\Accontrol\Database\Seeders;

use Illuminate\Database\Seeder;

class DefaultUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole       = config('accontrol.role.model')::where('name', '=', 'User')->first();
        $adminRole      = config('accontrol.role.model')::where('name', '=', 'Admin')->first();
        $permissions    = config('accontrol.permission.model')::all();

        /*
         * Add Users
         *
         */
        echo "\e[32mSeeding:\e[0m Accontrol - DefaultUsersTableSeeder\r\n";

        $admin = config('custom-user.user.model')::where('email', '=', 'admin@admin.com')->first();

        if ($admin === null) {
            $admin = config('custom-user.user.model')::create([
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password'),
                'is_admin' => 1
            ]);
        }

        $admin->attachRole($adminRole);
        
        foreach ($permissions as $permission) {
            $admin->attachPermission($permission);
        }

        echo "\e[32mSeeding:\e[0m Accontrol - DefaultUsersTableSeeder - User:admin@admin.com\r\n";

        $user = config('custom-user.user.model')::where('email', '=', 'user@user.com')->first();

        if ($user === null) {
            $user = config('custom-user.user.model')::create([
                'name'     => 'User',
                'email'    => 'user@user.com',
                'password' => bcrypt('password'),
            ]);
        }

        $user ->attachRole($userRole);

        echo "\e[32mSeeding:\e[0m Accontrol - DefaultUsersTableSeeder - User:user@user.com.com\r\n";
    }
}