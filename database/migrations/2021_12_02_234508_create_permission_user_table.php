<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissionUserEnabled              = config('accontrol.permission_user.enabled');
        $permissionUserTable                = config('accontrol.permission_user.table.name');
        $permissionUserTablePK              = config('accontrol.permission_user.table.primary_key');
        $permissionUserTablePermissionFK    = config('accontrol.permission_user.table.permission_foreign_key');
        $permissionUserTableUserFK          = config('accontrol.permission_user.table.user_foreign_key');

        $permissionsTable                   = config('accontrol.permission.table.name');
        $permissionsTablePK                 = config('accontrol.permission.table.primary_key');

        $usersTable                         = config('custom-user.user.table.name');
        $usersTablePK                       = config('custom-user.user.table.primary_key');

        if ($permissionUserEnabled) {
            if (!Schema::hasTable($permissionUserTable)) {
                Schema::create($permissionUserTable, function (Blueprint $table)
                use ($permissionUserTablePK, $permissionUserTablePermissionFK, $permissionsTable, $permissionsTablePK,
                        $permissionUserTableUserFK, $usersTable, $usersTablePK) {
                    $table->id($permissionUserTablePK);

                    $table->unsignedBigInteger($permissionUserTablePermissionFK);
                    $table->foreign($permissionUserTablePermissionFK)
                            ->references($permissionsTable)
                            ->on($permissionsTablePK) 
                            ->onDelete('cascade');

                    $table->unsignedBigInteger($permissionUserTableUserFK);
                    $table->foreign($permissionUserTableUserFK)
                            ->references($usersTable)
                            ->on($usersTablePK) 
                            ->onDelete('cascade');

                    $table->timestamps();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissionUserTable          = config('accontrol.permission_user.table.name');

        Schema::dropIfExists($permissionUserTable);
    }
}
