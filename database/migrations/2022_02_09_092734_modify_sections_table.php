<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('sections')->truncate();
        Schema::enableForeignKeyConstraints();

        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('ext_section_id');
            $table->dropColumn('title');
            $table->unsignedBigInteger('all_section_id')->after('exam_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['all_section_id']);
            $table->dropColumn('all_section_id');
            $table->unsignedInteger('ext_section_id');
            $table->string('title');
        });
    }
}
