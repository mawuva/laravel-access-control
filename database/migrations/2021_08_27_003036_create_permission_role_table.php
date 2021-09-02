<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource_name                          = config('accontrol.permission_role.resource_name');

        $table                                  = config('accontrol.permission_role.table.name');
        $permission_role_table_pk               = config('accontrol.permission_role.table.primary_key');

        $permissions_table                      = config('accontrol.permission.table.name');
        $permissions_table_pk                   = config('accontrol.permission.table.primary_key');
        $permissions_resource_name              = config('accontrol.permission.resource_name');

        $roles_table                            = config('accontrol.role.table.name');
        $roles_table_pk                         = config('accontrol.role.table.primary_key');
        $roles_resource_name                    = config('accontrol.role.resource_name');

        $permission_role_table_role_fk          = config('accontrol.permission_role.table.role_foreign_key');
        $permission_role_table_permission_fk    = config('accontrol.permission_role.table.permission_foreign_key');
        
        if (resource_is_enabled_and_does_not_exists_in_schema($resource_name)) {
            Schema::create($table, function (Blueprint $table)
            use (
                $permission_role_table_pk,
                $roles_resource_name, $roles_table, $roles_table_pk, $permission_role_table_role_fk,
                $permissions_resource_name, $permissions_table, $permissions_table_pk, $permission_role_table_permission_fk
            ) {
                $table->id($permission_role_table_pk) ->unsigned();

                if (resource_is_enabled_and_exists_in_schema($permissions_resource_name)) {
                    $table->unsignedBigInteger($permission_role_table_permission_fk)->unsigned()->index();
                    $table->foreign($permission_role_table_permission_fk)->references($permissions_table_pk)->on($permissions_table)->onDelete('cascade');
                }

                if (resource_is_enabled_and_exists_in_schema($roles_resource_name)) {
                    $table->unsignedBigInteger($permission_role_table_role_fk)->unsigned()->index();
                    $table->foreign($permission_role_table_role_fk)->references($roles_table_pk)->on($roles_table)->onDelete('cascade');
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
        $table  = config('accontrol.permission_role.table.name');

        Schema::dropIfExists($table);
    }
}
