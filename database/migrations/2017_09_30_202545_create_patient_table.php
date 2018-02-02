<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient', function (Blueprint $table) {
            $table->increments('patient_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->integer('age');
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('room_number')->default(0);
            $table->string('visit_date');
            $table->string('submitted_date')->nullable();
            $table->boolean('completed_flag')->default(0);
            $table->integer('module_id')->unsigned();
            $table->boolean('archived')->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        //Adding foreign key constraint with module table
        Schema::table('patient', function (Blueprint $table) {
            $table->foreign('module_id')->references('module_id')->on('module');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient');
    }
}