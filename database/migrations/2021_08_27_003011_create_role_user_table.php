<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource_name              = config('accontrol.role_user.resource_name');

        $table                      = config('accontrol.role_user.table.name');
        $role_user_table_pk         = config('accontrol.role_user.table.primary_key');

        $roles_table                = config('accontrol.role.table.name');
        $roles_table_pk             = config('accontrol.role.table.primary_key');
        $roles_resource_name        = config('accontrol.role.resource_name');

        $users_table                = config('accontrol.user.table.name');
        $users_table_pk             = config('accontrol.user.table.primary_key');
        $users_resource_name        = config('accontrol.user.resource_name');

        $role_user_table_role_fk    = config('accontrol.role_user.table.role_foreign_key');
        $role_user_table_user_fk    = config('accontrol.role_user.table.user_foreign_key');

        if (resource_is_enabled_and_does_not_exists_in_schema($resource_name)) {
            Schema::create($table, function (Blueprint $table)
            use (
                $role_user_table_pk,
                $roles_resource_name, $roles_table, $roles_table_pk, $role_user_table_role_fk,
                $users_resource_name, $users_table, $users_table_pk, $role_user_table_user_fk
            ) {
                $table->id($role_user_table_pk) ->unsigned();

                if (resource_is_enabled_and_exists_in_schema($roles_resource_name)) {
                    $table->unsignedBigInteger($role_user_table_role_fk)->unsigned()->index();
                    $table->foreign($role_user_table_role_fk)->references($roles_table_pk)->on($roles_table)->onDelete('cascade');
                }

                if (resource_is_enabled_and_exists_in_schema($users_resource_name)) {
                    $table->unsignedBigInteger($role_user_table_user_fk)->unsigned()->index();
                    $table->foreign($role_user_table_user_fk)->references($users_table_pk)->on($users_table)->onDelete('cascade');
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
        $table  = config('accontrol.role_user.table.name');

        Schema::dropIfExists($table);
    }
}
