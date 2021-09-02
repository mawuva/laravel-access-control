<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource_name                          = config('accontrol.permission_user.resource_name');

        $table                                  = config('accontrol.permission_user.table.name');
        $permission_user_table_pk               = config('accontrol.permission_user.table.primary_key');

        $permissions_table                      = config('accontrol.permission.table.name');
        $permissions_table_pk                   = config('accontrol.permission.table.primary_key');
        $permissions_resource_name              = config('accontrol.permission.resource_name');

        $users_table                            = config('accontrol.user.table.name');
        $users_table_pk                         = config('accontrol.user.table.primary_key');
        $users_resource_name                    = config('accontrol.user.resource_name');

        $permission_user_table_user_fk          = config('accontrol.permission_user.table.user_foreign_key');
        $permission_user_table_permission_fk    = config('accontrol.permission_user.table.permission_foreign_key');
        
        if (resource_is_enabled_and_does_not_exists_in_schema($resource_name)) {
            Schema::create($table, function (Blueprint $table)
            use (
                $permission_user_table_pk,
                $users_resource_name, $users_table, $users_table_pk, $permission_user_table_user_fk,
                $permissions_resource_name, $permissions_table, $permissions_table_pk, $permission_user_table_permission_fk
            ) {
                $table->id($permission_user_table_pk) ->unsigned();

                if (resource_is_enabled_and_exists_in_schema($permissions_resource_name)) {
                    $table->unsignedBigInteger($permission_user_table_permission_fk)->unsigned()->index();
                    $table->foreign($permission_user_table_permission_fk)->references($permissions_table_pk)->on($permissions_table)->onDelete('cascade');
                }

                if (resource_is_enabled_and_exists_in_schema($users_resource_name)) {
                    $table->unsignedBigInteger($permission_user_table_user_fk)->unsigned()->index();
                    $table->foreign($permission_user_table_user_fk)->references($users_table_pk)->on($users_table)->onDelete('cascade');
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
        $table  = config('accontrol.permission_user.table.name');

        Schema::dropIfExists($table);
    }
}
