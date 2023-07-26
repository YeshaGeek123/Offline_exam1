<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->after('id', function(Blueprint $table) {
                $table->unsignedInteger('sequence_number');
                $table->unsignedInteger('ext_student_id')->nullable();
            });
            $table->after('phone', function(Blueprint $table) {
                $table->string('social');
                $table->string('school');
                $table->date('graduation_date');
            });
            $table->dropUnique(['code']);
            $table->dropColumn('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('sequence_number');
            $table->dropColumn('ext_student_id');
            $table->dropColumn('social');
            $table->dropColumn('school');
            $table->dropColumn('graduation_date');
            $table->string('code')->unique();
        });
    }
}
