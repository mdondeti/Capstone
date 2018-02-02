<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesnavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules_navigations', function (Blueprint $table) {
            $table->integer('navigation_id');
            $table->integer('module_id');
            $table->boolean('visible');
          //  $table->primary(['module_id', 'navigation_id']);
            $table->timestamps();
        });
        //Adding foreign key constraint with module table
        Schema::table('modules_navigations', function (Blueprint $table) {
            $table->foreign('module_id')->references('module_id')->on('module');
        });
        //Adding foreign key constraint with navigations table
        Schema::table('modules_navigations', function (Blueprint $table) {
            $table->foreign('navigation_id')->references('navigation_id')->on('navigations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules_navigations');
    }
}
