<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmationToNewEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_evaluations', function (Blueprint $table) {
            $table->boolean('confirmation_status')->default(0)->comment('0: Pending, 1: Confirmed')->after('is_ongoing');
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
            $table->dropColumn('confirmation_status');
        });
    }
}
