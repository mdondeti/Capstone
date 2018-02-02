<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('security', function (Blueprint $table) {
            $table->increments('id');
            $table->string('security_question'); 
            $table->timestamps();
        });

        //Inserting security questions
        DB::table('security')->insert([
            [
                'security_question' => 'Your first employer'
            ],
            [
                'security_question' => 'Your mother maiden name'
            ],
            [
                'security_question' => 'Your first car'
            ],
            [
                'security_question' => 'State where you lived at the age of 5'
            ],
            [
                'security_question' => 'Your favourite city'
            ],
            [
                'security_question' => 'Your School best friend name'
            ],
            [
                'security_question' => 'Your favourite holiday destination'
            ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security');
    }
}
