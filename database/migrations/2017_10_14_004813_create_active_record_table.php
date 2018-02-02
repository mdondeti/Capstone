<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_record', function (Blueprint $table) {
            $table->increments('active_record_id');
            $table->integer('patient_id')->unsigned();
            $table->integer('navigation_id')->unsigned();
            $table->integer('doc_control_id')->unsigned();
            $table->integer('doc_control_group')->nullable();
            $table->integer('doc_control_group_order')->nullable();
            $table->string('value',16000)->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });


        //Adding foreign key constraint with navigation table
        Schema::table('active_record', function (Blueprint $table) {
            $table->foreign('navigation_id')->references('navigation_id')->on('navigations');
        });


        Schema::table('active_record', function (Blueprint $table) {
            $table->foreign('patient_id')->references('patient_id')->on('patient');
        });

        Schema::table('active_record', function (Blueprint $table) {
            $table->foreign('doc_control_id')->references('doc_control_id')->on('doc_control');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_record');
    }
}