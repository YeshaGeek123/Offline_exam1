<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ext_section_id')->nullable();
            $table->string('title');
            $table->timestamps();
        });

        DB::table('all_sections')->insert([
            ['ext_section_id' => '1', 'title' => 'Section 1'],
            ['ext_section_id' => '2', 'title' => 'Section 2'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('all_sections');
    }
}
