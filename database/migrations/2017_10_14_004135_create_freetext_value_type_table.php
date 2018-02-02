<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreetextValueTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freetext_value_type', function (Blueprint $table) {
            $table->increments('freetext_value_type_id');
            $table->string('freetext_value_type');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        //Inserting record for number
        DB::table('freetext_value_type')->insert(
            array(
                'freetext_value_type' => 'number',
                'created_by' => 1
            )
        );


        //Inserting record for date
        DB::table('freetext_value_type')->insert(
            array(
                'freetext_value_type' => 'date',
                'created_by' => 1
            )
        );


        //Inserting record for character
        DB::table('freetext_value_type')->insert(
            array(
                'freetext_value_type' => 'character',
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
        Schema::dropIfExists('freetext_value_type');
    }
}
