<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ext_procedure_id')->nullable();
            $table->string('title');
            $table->timestamps();
        });

        DB::table('procedures')->insert([
            ['ext_procedure_id' => '1', 'title' => 'Procedure 1'],
            ['ext_procedure_id' => '2', 'title' => 'Procedure 2'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedures');
    }
}
