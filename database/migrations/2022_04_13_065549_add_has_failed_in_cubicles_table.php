<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHasFailedInCubiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cubicles', function (Blueprint $table) {
            $table->boolean('has_failed')->default(0)->after('need_cleanup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cubicles', function (Blueprint $table) {
            $table->dropColumn('has_failed');
        });
    }
}
