<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->unsignedInteger('ext_exam_id')->after('id');
            $table->after('exam_end', function(Blueprint $table) {
                $table->string('type');
                $table->string('facility_name');
                $table->string('state');
                $table->string('zip');
                $table->string('address');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->string('title');
            $table->dropColumn('ext_exam_id');
            $table->dropColumn('type');
            $table->dropColumn('facility_name');
            $table->dropColumn('state');
            $table->dropColumn('zip');
            $table->dropColumn('address');
        });
    }
}
