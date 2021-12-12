<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $uuidEnabled        = config('accontrol.uuids.enabled');
        $uuidColumn         = config('accontrol.uuids.column');

        $actionEnabled      = config('accontrol.action.enabled');
        $actionsTable       = config('accontrol.action.table.name');
        $actionsTablePK     = config('accontrol.action.table.primary_key');

        if ($actionEnabled) {
            if (!Schema::hasTable($actionsTable)) {
                Schema::create($actionsTable, function (Blueprint $table) 
                use ($actionsTablePK, $uuidEnabled, $uuidColumn) {
                    $table->id($actionsTablePK);

                    if ($uuidEnabled && $uuidColumn !== null) {
                        $table->uuid($uuidColumn);
                    }
                    
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->longText('description')->nullable();
                    $table->boolean('available_for_all_entities') ->nullable();
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
        $actionsTable  = config('accontrol.action.table.name');

        Schema::dropIfExists($actionsTable);
    }
}
