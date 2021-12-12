<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntitiesTable extends Migration
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

        $entityEnabled     = config('accontrol.entity.enabled');
        $entitiesTable      = config('accontrol.entity.table.name');
        $entitiesTablePK    = config('accontrol.entity.table.primary_key');
        
        if ($entityEnabled) {
            if (!Schema::hasTable($entitiesTable)) {
                Schema::create($entitiesTable, function (Blueprint $table) 
                use ($entitiesTablePK, $uuidEnabled, $uuidColumn) {
                    $table->id($entitiesTablePK);

                    if ($uuidEnabled && $uuidColumn !== null) {
                        $table->uuid($uuidColumn);
                    }
                    
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->string('model')->nullable();
                    $table->string('description')->nullable();
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
        Schema::dropIfExists('entities');
    }
}
