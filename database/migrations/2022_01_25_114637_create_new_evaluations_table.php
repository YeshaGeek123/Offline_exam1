<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('cubicle_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('group_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_ongoing')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_evaluations');
    }
}
