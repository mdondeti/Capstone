<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientRecordStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_record_status', function (Blueprint $table) {
            $table->increments('patient_record_status_id');
            $table->string('patient_record_status');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        //Inserting record for saved
        DB::table('patient_record_status')->insert(
            array(
                'patient_record_status' => 'saved',
                'created_by' => 1
            )
        );

        //Inserting record for submitted for review
        DB::table('patient_record_status')->insert(
            array(
                'patient_record_status' => 'submitted for review',
                'created_by' => 1
            )
        );

        //Inserting record for reviewed
        DB::table('patient_record_status')->insert(
            array(
                'patient_record_status' => 'reviewed',
                'created_by' => 1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_record_status');
    }
}
