<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roleUserEnabled        = config('accontrol.role_user.enabled');
        $roleUserTable          = config('accontrol.role_user.table.name');
        $roleUserTablePK        = config('accontrol.role_user.table.primary_key');
        $roleUserTableRoleFK    = config('accontrol.role_user.table.role_foreign_key');
        $roleUserTableUserFK    = config('accontrol.role_user.table.user_foreign_key');

        $rolesTable             = config('accontrol.role.table.name');
        $rolesTablePK           = config('accontrol.role.table.primary_key');

        $usersTable             = config('custom-user.user.table.name');
        $usersTablePK           = config('custom-user.user.table.primary_key');

        if ($roleUserEnabled) {
            if (!Schema::hasTable($roleUserTable)) {
                Schema::create($roleUserTable, function (Blueprint $table)
                use ($roleUserTablePK, $roleUserTableRoleFK, $rolesTable, $rolesTablePK,
                        $roleUserTableUserFK, $usersTable, $usersTablePK) {
                    $table->id($roleUserTablePK);

                    $table->unsignedBigInteger($roleUserTableRoleFK);
                    $table->foreign($roleUserTableRoleFK)
                            ->references($rolesTable)
                            ->on($rolesTablePK) 
                            ->onDelete('cascade');

                    $table->unsignedBigInteger($roleUserTableUserFK);
                    $table->foreign($roleUserTableUserFK)
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
        $roleUserTable          = config('accontrol.role_user.table.name');

        Schema::dropIfExists($roleUserTable);
    }
}
