<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissionRoleEnabled              = config('accontrol.permission_role.enabled');
        $permissionRoleTable                = config('accontrol.permission_role.table.name');
        $permissionRoleTablePK              = config('accontrol.permission_role.table.primary_key');
        $permissionRoleTablePermissionFK    = config('accontrol.permission_role.table.permission_foreign_key');
        $permissionRoleTableRoleFK          = config('accontrol.permission_role.table.role_foreign_key');

        $permissionsTable                   = config('accontrol.permission.table.name');
        $permissionsTablePK                 = config('accontrol.permission.table.primary_key');

        $rolesTable                         = config('accontrol.role.table.name');
        $rolesTablePK                       = config('accontrol.role.table.primary_key');

        if ($permissionRoleEnabled) {
            Schema::create($permissionRoleTable, function (Blueprint $table)
            use ($permissionRoleTablePK, $permissionRoleTablePermissionFK, $permissionsTable, $permissionsTablePK,
                    $permissionRoleTableRoleFK, $rolesTable, $rolesTablePK) {
                $table->id($permissionRoleTablePK);

                $table->unsignedBigInteger($permissionRoleTablePermissionFK);
                $table->foreign($permissionRoleTablePermissionFK)
                        ->references($permissionsTable)
                        ->on($permissionsTablePK) 
                        ->onDelete('cascade');

                $table->unsignedBigInteger($permissionRoleTableRoleFK);
                $table->foreign($permissionRoleTableRoleFK)
                        ->references($rolesTable)
                        ->on($rolesTablePK) 
                        ->onDelete('cascade');

                $table->timestamps();
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
        $permissionRoleTable          = config('accontrol.permission_role.table.name');

        Schema::dropIfExists($permissionRoleTable);
    }
}
