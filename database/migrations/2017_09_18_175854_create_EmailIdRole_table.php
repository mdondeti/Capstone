<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailIdRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EmailIdRole', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique(); 
            $table->string('role');
            $table->timestamps();
        });

         //Inserting record for admin
        DB::table('EmailIdRole')->insert(
            array(
                'email' => 'admin@wechart.com',
                'role' => 'Admin'
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
        Schema::dropIfExists('EmailIdRole');
    }
}
