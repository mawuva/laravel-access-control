<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions.
         */
        $permissions = config('accontrol.permission.model')::all();

        /**
         * Get Admin Roles
         */
        $roleAdmin = config('accontrol.role.model')::where('slug', '=', 'admin')->first()
            ?? config('accontrol.role.model')::where('name', '=', 'Admin')->first();

        /**
         * Attach Permissions to Roles.
         */
        
        echo "\e[32mSeeding:\e[0m Accontrol - DefaultConnectRelationshipsSeeder\r\n";

        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);

            echo "\e[32mSeeding:\e[0m Accontrol - DefaultConnectRelationshipsSeeder - Role:Admin attached to Permission:".$permission->slug."\r\n";
        }
    }
}