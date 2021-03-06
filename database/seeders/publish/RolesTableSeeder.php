<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $roleItems = [
            [
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ],
            [
                'name'        => 'User',
                'slug'        => 'user',
                'description' => 'User Role',
                'level'       => 1,
            ],
            [
                'name'        => 'Unverified',
                'slug'        => 'unverified',
                'description' => 'Unverified Role',
                'level'       => 0,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        echo "\e[32mSeeding:\e[0m Accontrol - DefaultRoleItemsTableSeeder\r\n";

        foreach ($roleItems as $roleItem) {
            $newRoleItem = config('accontrol.role.model')::where('slug', '=', $roleItem['slug'])->first();

            if ($newRoleItem === null) {
                $newRoleItem = config('accontrol.role.model')::create([
                    'name'          => $roleItem['name'],
                    'slug'          => $roleItem['slug'],
                    'description'   => $roleItem['description'],
                    'level'         => $roleItem['level'],
                ]);

                echo "\e[32mSeeding:\e[0m Accontrol - DefaultRoleItemsTableSeeder - Role:".$roleItem['slug']."\r\n";
            }
        }
    }
}