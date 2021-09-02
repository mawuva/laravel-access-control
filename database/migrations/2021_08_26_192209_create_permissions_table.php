<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource_name                  = config('accontrol.permission.resource_name');

        $table                          = config('accontrol.permission.table.name');
        $permissions_table_pk           = config('accontrol.permission.table.primary_key');

        $uuid_enable                    = config('accontrol.uuids.enable');
        $uuid_column                    = config('accontrol.uuids.column');

        $actions_table                  = config('accontrol.action.table.name');
        $actions_table_pk               = config('accontrol.action.table.primary_key');
        $actions_resource_name          = config('accontrol.action.resource_name');
        
        $entities_table                 = config('accontrol.entity.table.name');
        $entities_table_pk              = config('accontrol.entity.table.primary_key');
        $entities_resource_name         = config('accontrol.entity.resource_name');

        $permissions_table_action_fk    = config('accontrol.permission.table.action_foreign_key');
        $permissions_table_entity_fk    = config('accontrol.permission.table.entity_foreign_key');

        if (resource_is_enabled_and_does_not_exists_in_schema($resource_name)) {
            Schema::create($table, function (Blueprint $table)
            use (
                $permissions_table_pk, $uuid_enable, $uuid_column,
                $actions_resource_name, $actions_table, $actions_table_pk, $permissions_table_action_fk,
                $entities_resource_name, $entities_table, $entities_table_pk, $permissions_table_entity_fk
            ) {
                
                $table->id($permissions_table_pk) ->unsigned();

                if ($uuid_enable && $uuid_column !== null) {
                    $table->uuid($uuid_column);
                }

                $table->string('name');
                $table->string('slug')->unique();
                $table->string('description')->nullable();

                if (resource_is_enabled_and_exists_in_schema($actions_resource_name)) {
                    $table->unsignedBigInteger($permissions_table_action_fk)->unsigned()->index() ->nullable();
                    $table->foreign($permissions_table_action_fk)->references($actions_table_pk)->on($actions_table);
                }

                if (resource_is_enabled_and_exists_in_schema($entities_resource_name)) {
                    $table->unsignedBigInteger($permissions_table_entity_fk)->unsigned()->index() ->nullable();
                    $table->foreign($permissions_table_entity_fk)->references($entities_table_pk)->on($entities_table);
                }

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table  = config('accontrol.permission.table.name');

        Schema::dropIfExists($table);
    }
}
