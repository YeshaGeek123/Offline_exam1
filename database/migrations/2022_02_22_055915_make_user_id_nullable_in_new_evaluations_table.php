<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUserIdNullableInNewEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_evaluations', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->change();
            $table->unsignedInteger('procedure_id')->nullable()->after('section_id');
            $table->integer('status')->default(0)->comment('0: Pending, 1: Started, 2: Pass, 3: Fail')->change();
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
            $table->unsignedInteger('user_id')->change();
            $table->dropColumn('procedure_id');
            $table->integer('status')->default(0)->change();
        });
    }
}
