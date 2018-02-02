<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password',60);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('contactno')->nullable();
            $table->string('role');
            $table->string('departmentName')->nullable();
            $table->boolean('archived')->default(0);
            $table->integer('security_question1_Id')->unsigned();
            $table->string('security_answer1');
            $table->integer('security_question2_Id')->unsigned();
            $table->string('security_answer2');
            $table->integer('security_question3_Id')->unsigned();
            $table->string('security_answer3');
            $table->rememberToken();
            $table->timestamps();
        });

        //Adding foreign key constraint with EmailidRole table
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('email')->references('email')->on('EmailIdRole');
        });

        //Adding foreign key constraints with Security table
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('security_question1_Id')->references('id')->on('security');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('security_question2_Id')->references('id')->on('security');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('security_question3_Id')->references('id')->on('security');
        });

        //Inserting record for admin
        DB::table('users')->insert(
            array(
                'email' => 'admin@wechart.com',
                'password' => Hash::make('wechartadmin'),
                'firstname' => 'Thanh',
                'lastname' => 'Nguyen',
                'role' => 'Admin',
                'security_question1_Id' => 1,
                'security_answer1' => 'UNMC',
                'security_question2_Id' => 4,
                'security_answer2' => 'Texas',
                'security_question3_Id' => '5',
                'security_answer3' => 'Omaha'
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
        Schema::dropIfExists('users');
    }
}
