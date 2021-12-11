<?php

namespace Mawuekom\Accontrol\Database\Seeders;

use Illuminate\Database\Seeder;

class DefaultPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $permissionItems = [
            [
                'name'        => 'Can View Users',
                'slug'        => 'view-users',
                'description' => 'Can view users',
                //'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Create Users',
                'slug'        => 'create-users',
                'description' => 'Can create new users',
                //'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit Users',
                'slug'        => 'edit-users',
                'description' => 'Can edit users',
                //'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Users',
                'slug'        => 'delete-users',
                'description' => 'Can delete users',
                //'model'       => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        echo "\e[32mSeeding:\e[0m Accontrol - DefaultPermissionItemsTableSeeder\r\n";
        
        foreach ($permissionItems as $permissionItem) {
            $newPermissionItem = config('accontrol.permission.model')::where('slug', '=', $permissionItem['slug'])->first();

            if ($newPermissionItem === null) {
                $newPermissionItem = config('accontrol.permission.model')::create([
                    'name'          => $permissionItem['name'],
                    'slug'          => $permissionItem['slug'],
                    'description'   => $permissionItem['description'],
                    //'model'         => $permissionItem['model'],
                ]);

                echo "\e[32mSeeding:\e[0m Accontrol - DefaultpermissionItemsTableSeeder - Permission:".$permissionItem['slug']."\r\n";
            }
        }
    }
}