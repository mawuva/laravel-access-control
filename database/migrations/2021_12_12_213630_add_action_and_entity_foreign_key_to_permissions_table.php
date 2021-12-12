<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActionAndEntityForeignKeyToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissionsTable           = config('accontrol.permission.table.name');
        $permissionsTableActionFK   = config('accontrol.permission.table.action_foreign_key');
        $permissionsTableEntityFK   = config('accontrol.permission.table.entity_foreign_key');

        $actionEnabled              = config('accontrol.action.enabled');
        $actionsTable               = config('accontrol.action.table.name');
        $actionsTablePK             = config('accontrol.action.table.primary_key');
        
        $entityEnabled              = config('accontrol.entity.enabled');
        $entitiesTable              = config('accontrol.entity.table.name');
        $entitiesTablePK            = config('accontrol.entity.table.primary_key');

        if ($actionEnabled && $entityEnabled) {
            Schema::table($permissionsTable, function (Blueprint $table)
            use ($permissionsTableActionFK, $actionsTable, $actionsTablePK, 
                $permissionsTableEntityFK, $entitiesTable, $entitiesTablePK) {
                
                $table->unsignedBigInteger($permissionsTableActionFK)->nullable() ->after('description');
                $table->foreign($permissionsTableActionFK)
                        ->references($actionsTablePK)
                        ->on($actionsTable);

                $table->unsignedBigInteger($permissionsTableEntityFK)->nullable() ->after($permissionsTableActionFK);
                $table->foreign($permissionsTableEntityFK)
                        ->references($entitiesTablePK)
                        ->on($entitiesTable);
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
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
}
