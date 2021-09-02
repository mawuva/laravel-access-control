<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resource_name      = config('accontrol.role.resource_name');

        $table              = config('accontrol.role.table.name');
        $roles_table_pk     = config('accontrol.role.table.primary_key');

        $uuid_enable        = config('accontrol.uuids.enable');
        $uuid_column        = config('accontrol.uuids.column');

        if (resource_is_enabled_and_does_not_exists_in_schema($resource_name)) {
            Schema::create($table, function (Blueprint $table)
            use ($roles_table_pk, $uuid_enable, $uuid_column) {
                
                $table->id($roles_table_pk) ->unsigned();

                if ($uuid_enable && $uuid_column !== null) {
                    $table->uuid($uuid_column);
                }

                $table->string('name');
                $table->string('slug')->unique();
                $table->string('description')->nullable();
                $table->integer('level')->default(1);
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
        $table  = config('accontrol.role.table.name');

        Schema::dropIfExists($table);
    }
}
