<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $uuidEnabled            = config('accontrol.uuids.enabled');
        $uuidColumn             = config('accontrol.uuids.column');

        $permissionEnabled      = config('accontrol.permission.enabled');
        $permissionsTable       = config('accontrol.permission.table.name');
        $permissionsTablePK     = config('accontrol.permission.table.primary_key');

        if ($permissionEnabled) {
            if (!Schema::hasTable($permissionsTable)) {
                Schema::create($permissionsTable, function (Blueprint $table) 
                use ($permissionsTablePK, $uuidEnabled, $uuidColumn) {
                    $table->id($permissionsTablePK);

                    if ($uuidEnabled && $uuidColumn !== null) {
                        $table->uuid($uuidColumn);
                    }
                    
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->longText('description')->nullable();
                    $table->timestamps();
                    $table->softDeletes();
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
        $permissionsTable  = config('accontrol.permission.table.name');

        Schema::dropIfExists($permissionsTable);
    }
}
