<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInNewEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('new_evaluations')->truncate();
        Schema::enableForeignKeyConstraints();

        Schema::table('new_evaluations', function (Blueprint $table) {
            $table->renameColumn('group_id', 'section_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_evaluations', function (Blueprint $table) {
            $table->renameColumn('section_id', 'group_id');
        });
    }
}
