<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Mawuekom\Accontrol\Events\EntityWasCreated;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Entity Types
         *
         */
        $entityItems = [
            [
                'name'          => 'Action',
                'slug'          => 'action',
                'model'         => config('accontrol.action.model'),
                'description'   => 'Operations that are done on an entity.',
            ],
            [
                'name'          => 'Entity',
                'slug'          => 'entity',
                'model'         => config('accontrol.entity.model'),
                'description'   => 'Operations that are done on an entity.',
            ],
            [
                'name'          => 'Permission',
                'slug'          => 'permission',
                'model'         => config('accontrol.permission.model'),
                'description'   => 'Authorization which are granted to users.',
            ],
            [
                'name'          => 'Role',
                'slug'          => 'role',
                'model'         => config('accontrol.role.model'),
                'description'   => 'Roles are a group of permissions or roles.',
            ],
            [
                'name'          => 'User',
                'slug'          => 'user',
                'model'         => App\Models\User::class,
                'description'   => 'Users who run the app.',
            ],
        ];

        /*
         * Add entity Items
         *
         */
        echo "\e[32mSeeding:\e[0m Accontrol - DefaultEntityItemsTableSeeder\r\n";
        
        foreach ($entityItems as $entityItem) {
            $newEntityItem = config('accontrol.entity.model')::where('slug', '=', $entityItem['slug'])->first();

            if ($newEntityItem === null) {
                $newEntityItem = config('accontrol.entity.model')::create([
                    'name'          => $entityItem['name'],
                    'slug'          => $entityItem['slug'],
                    'model'         => $entityItem['model'],
                    'description'   => $entityItem['description'],
                ]);

                event(new EntityWasCreated($newEntityItem));
                
                echo "\e[32mSeeding:\e[0m Accontrol - DefaultEntityItemsTableSeeder - Entity:".$entityItem['slug']."\r\n";
            }
        }
    }
}