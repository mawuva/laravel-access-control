<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource_name          = config('accontrol.entity.resource_name');

        $table                  = config('accontrol.entity.table.name');
        $entities_table_pk      = config('accontrol.entity.table.primary_key');

        $uuid_enable            = config('accontrol.uuids.enable');
        $uuid_column            = config('accontrol.uuids.column');

        if (resource_is_enabled_and_does_not_exists_in_schema($resource_name)) {
            Schema::create($table, function (Blueprint $table)
            use ($entities_table_pk, $uuid_enable, $uuid_column) {
                
                $table->id($entities_table_pk) ->unsigned();

                if ($uuid_enable && $uuid_column !== null) {
                    $table->uuid($uuid_column);
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table  = config('accontrol.entity.table.name');

        Schema::dropIfExists($table);
    }
}
