<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $uuidEnabled     = config('accontrol.uuids.enabled');
        $uuidColumn      = config('accontrol.uuids.column');

        $roleEnabled     = config('accontrol.role.enabled');
        $rolesTable      = config('accontrol.role.table.name');
        $rolesTablePK    = config('accontrol.role.table.primary_key');
        
        if ($roleEnabled) {
            if (!Schema::hasTable($rolesTable)) {
                Schema::create($rolesTable, function (Blueprint $table) 
                use ($rolesTablePK, $uuidEnabled, $uuidColumn) {
                    $table->id($rolesTablePK);

                    if ($uuidEnabled && $uuidColumn !== null) {
                        $table->uuid($uuidColumn);
                    }
                    
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->longText('description')->nullable();
                    $table->integer('level')->default(1);
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
        $rolesTable  = config('accontrol.role.table.name');

        Schema::dropIfExists($rolesTable);
    }
}
