<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocControlTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::create('doc_control_type', function (Blueprint $table) {
        $table->increments('doc_control_type_id');
        $table->string('control_type');
        $table->integer('created_by')->unsigned();
        $table->integer('updated_by')->unsigned()->nullable();
        $table->timestamps();
    });

        //Inserting record for radio
        DB::table('doc_control_type')->insert(
            array(
                'control_type' => 'radio',
                'created_by' => 1
            )
        );

        //Inserting record for checkbox
        DB::table('doc_control_type')->insert(
            array(
                'control_type' => 'checkbox',
                'created_by' => 1
            )
        );


        //Inserting record for freetext
        DB::table('doc_control_type')->insert(
            array(
                'control_type' => 'freetext',
                'created_by' => 1
            )
        );


        //Inserting record for dropdown
        DB::table('doc_control_type')->insert(
            array(
                'control_type' => 'dropdown',
                'created_by' => 1
            )
        );


        //Inserting record for searchbar
        DB::table('doc_control_type')->insert(
            array(
                'control_type' => 'searchbar',
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
        Schema::dropIfExists('doc_control_type');
    }
}
