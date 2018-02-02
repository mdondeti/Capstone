<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->increments('navigation_id');
            $table->string('navigation_name');
            $table->integer('parent_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('navigations', function (Blueprint $table) {
            $table->foreign('parent_id')->references('navigation_id')->on('navigations');
        });

        DB::table('navigations')->insert([
            [
                'navigation_name' => 'History of Present Illness (HPI)',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'Medical History',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'Personal History (PMHx)',
                'parent_id' =>  2
            ],
            [
                'navigation_name' => 'Family History (FMHx)',
                'parent_id' =>  2
            ],
            [
                'navigation_name' => 'Surgical History',
                'parent_id' =>  2
            ],
            [
                'navigation_name' => 'Social History (SHx)',
                'parent_id' =>  2
            ],
            [
                'navigation_name' => 'Medications',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'Vital Signs',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'Review of System (ROS)',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'Constitutional',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'HENT',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'Eyes',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'Respiratory',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'Cardiovascular',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'Musculoskeletal',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'Integumentary',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'Neurological',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'Psychological',
                'parent_id' =>  9
            ],
            [
                'navigation_name' => 'Gastrointestinal',
                'parent_id' =>  9
            ],

            [
                'navigation_name' => 'Physical Exam',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'Constitutional',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'HENT',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Eyes',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Respiratory',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Cardiovascular',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Musculoskeletal',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Integumentary',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Neurological',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Psychological',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Gastrointestinal',
                'parent_id' =>  20
            ],
            [
                'navigation_name' => 'Orders',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'Results',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'MDM/Plan',
                'parent_id' =>  null
            ],
            [
                'navigation_name' => 'Disposition',
                'parent_id' =>  null
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
        Schema::dropIfExists('navigations');
    }
}
