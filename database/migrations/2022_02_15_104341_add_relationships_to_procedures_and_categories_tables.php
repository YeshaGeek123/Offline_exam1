<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationshipsToProceduresAndCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('procedures')->truncate();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();
        
        Schema::table('procedures', function (Blueprint $table) {
            $table->unsignedInteger('all_section_id')->after('id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('procedure_id')->after('id');
        });

        DB::table('procedures')->insert([
            ['all_section_id' => '1', 'ext_procedure_id' => '1', 'title' => 'Procedure 1'],
            ['all_section_id' => '1', 'ext_procedure_id' => '2', 'title' => 'Procedure 2'],
        ]);

        DB::table('categories')->insert([
            ['procedure_id' => '1', 'ext_category_id' => '1', 'title' => 'Category 1'],
            ['procedure_id' => '1', 'ext_category_id' => '2', 'title' => 'Category 2'],
            ['procedure_id' => '2', 'ext_category_id' => '3', 'title' => 'Category 1'],
            ['procedure_id' => '2', 'ext_category_id' => '4', 'title' => 'Category 2'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('procedures')->truncate();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();

        Schema::table('procedures', function (Blueprint $table) {
            $table->dropColumn('all_section_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('procedure_id');
        });

        DB::table('procedures')->insert([
            ['ext_procedure_id' => '1', 'title' => 'Procedure 1'],
            ['ext_procedure_id' => '2', 'title' => 'Procedure 2'],
        ]);

        DB::table('categories')->insert([
            ['ext_category_id' => '1', 'title' => 'Category 1'],
            ['ext_category_id' => '2', 'title' => 'Category 2'],
        ]);
    }
}
