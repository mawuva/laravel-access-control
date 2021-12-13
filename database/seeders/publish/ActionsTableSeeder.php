<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Mawuekom\Accontrol\Events\ActionWasCreated;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Action Types
         *
         */
        $actionItems = [
            [
                'name'                          => 'Create',
                'slug'                          => 'create',
                'description'                   => 'Create new data',
                'available_for_all_entities'    => 1,
            ],
            [
                'name'                          => 'View',
                'slug'                          => 'view',
                'description'                   => 'View created data',
                'available_for_all_entities'    => 1,
            ],
            [
                'name'                          => 'Edit',
                'slug'                          => 'edit',
                'description'                   => 'Edit created data',
                'available_for_all_entities'    => 1,
            ],
            [
                'name'                          => 'Delete',
                'slug'                          => 'delete',
                'description'                   => 'Delete created data',
                'available_for_all_entities'    => 1,
            ],
            [
                'name'                          => 'Restore',
                'slug'                          => 'restore',
                'description'                   => 'Restore deleted data',
                'available_for_all_entities'    => 1,
            ],
        ];

        /*
         * Add action Items
         *
         */
        echo "\e[32mSeeding:\e[0m Accontrol - DefaultActionItemsTableSeeder\r\n";
        
        foreach ($actionItems as $actionItem) {
            $newActionItem = config('accontrol.action.model')::where('slug', '=', $actionItem['slug'])->first();

            if ($newActionItem === null) {
                $newActionItem = config('accontrol.action.model')::create([
                    'name'                          => $actionItem['name'],
                    'slug'                          => $actionItem['slug'],
                    'description'                   => $actionItem['description'],
                    'available_for_all_entities'    => $actionItem['available_for_all_entities'],
                ]);

                event(new ActionWasCreated($newActionItem));

                echo "\e[32mSeeding:\e[0m Accontrol - DefaultActionItemsTableSeeder - Action:".$actionItem['slug']."\r\n";
            }
        }
    }
}