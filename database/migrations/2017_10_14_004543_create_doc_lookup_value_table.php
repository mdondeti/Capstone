<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateDocLookupValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_lookup_value', function (Blueprint $table) {
            $table->integer('doc_control_id')->unsigned();
            $table->integer('lookup_value_id')->unsigned();
            $table->integer('sort_order_number')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('doc_lookup_value', function (Blueprint $table) {
            $table->foreign('doc_control_id')->references('doc_control_id')->on('doc_control');
        });
        Schema::table('doc_lookup_value', function (Blueprint $table) {
            $table->foreign('lookup_value_id')->references('lookup_value_id')->on('lookup_value');
        });
        /*  We are no longer including demographics in active record
                //Inserting record for documentation-male relation
                DB::table('doc_lookup_value')->insert(
                    array(
                        'doc_control_id' => ?,
                        'lookup_value_id' => 1,
                        'sort_order_number' => 1,
                        'created_by' => 1
                        )
                    );
                //Inserting record for female
                DB::table('doc_lookup_value')->insert(
                    array(
                        'doc_control_id' => ?,
                        'lookup_value_id' => 2,
                        'sort_order_number' => 2,
                        'created_by' => 1
                        )
                    );
        */
        //Inserting record for Smoke Tobacco - YES
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 11,		//Smoke Tobacco
                'lookup_value_id' => 3,		//YES
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        //Inserting record for Smoke Tobacco - NO
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 11,		//Smoke Tobacco
                'lookup_value_id' => 4,		//NO
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        //Inserting record for Non-Smoke Tobacco - YES
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 12,		//Non-Smoke Tobacco
                'lookup_value_id' => 3,		//YES
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        //Inserting record for Non-Smoke Tobacco - NO
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 12,		//Non-Smoke Tobacco
                'lookup_value_id' => 4,		//NO
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        //Inserting record for Alcohol - YES
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 13,		//Alcohol
                'lookup_value_id' => 3,		//YES
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        //Inserting record for Alcohol - NO
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 13,		//Alcohol
                'lookup_value_id' => 4,		//NO
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        //Inserting record for Sexual Activity - Active
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 14,		//Sexual Activity
                'lookup_value_id' => 5,		//Active
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        //Inserting record for Sexual Activity - Not active
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 14,		//Sexual Activity
                'lookup_value_id' => 6,		//Not Active
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        //Inserting record for Family Member - Status - Alive
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 7,		//Family Member Status
                'lookup_value_id' => 7,		//Alive
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        //Inserting record for Family Member - Status - Deceased
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 7,		//Family Member Status
                'lookup_value_id' => 8,		//Deseased
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - Constitution
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 25,		//ROS - Constitution
                'lookup_value_id' => 9,		//Fever
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 25,		//ROS - Constitution
                'lookup_value_id' => 10,		//Chills
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 25,		//ROS - Constitution
                'lookup_value_id' => 11,		//Fatigue
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 25,		//ROS - Constitution
                'lookup_value_id' => 12,		//Weight Changes - Gain
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 25,		//ROS - Constitution
                'lookup_value_id' => 13,		//Weight Changes - Loss
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 25,		//ROS - Constitution
                'lookup_value_id' => 14,		//Activity Changes
                'sort_order_number' => 6,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - HENT
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 27,			//ROS - HENT
                'lookup_value_id' => 16,		//Runny nose
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 27,			//ROS - HENT
                'lookup_value_id' => 17,		//Congestion
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 27,			//ROS - HENT
                'lookup_value_id' => 18,		//Sneezing
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 27,			//ROS - HENT
                'lookup_value_id' => 19,		//Dental Problem
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 27,			//ROS - HENT
                'lookup_value_id' => 20,		//Ear problem
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 27,			//ROS - HENT
                'lookup_value_id' => 21,		//throat/mouth problem
                'sort_order_number' => 6,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 27,			//ROS - HENT
                'lookup_value_id' => 22,		//nose problem
                'sort_order_number' => 6,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - Eyes
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 29,			//ROS - Eyes
                'lookup_value_id' => 23,		//Discharge
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 29,			//ROS - Eyes
                'lookup_value_id' => 24,		//Redness
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 29,			//ROS - Eyes
                'lookup_value_id' => 25,		//Pain
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 29,			//ROS - Eyes
                'lookup_value_id' => 26,		//Visual Changes
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - Respiratory
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 31,			//ROS - Respiratory
                'lookup_value_id' => 27,		//Cough
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 31,			//ROS - Respiratory
                'lookup_value_id' => 28,		//Shortness of breath (SOB)
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 31,			//ROS - Respiratory
                'lookup_value_id' => 29,		//Chest pressure/tightness
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 31,			//ROS - Respiratory
                'lookup_value_id' => 30,		//Wheezing
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - Cardiovascular
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 33,			//ROS - Cardiovascular
                'lookup_value_id' => 31,		//Chest pain
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 33,			//ROS - Cardiovascular
                'lookup_value_id' => 32,		//Palpitations
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - Musculoskeletal
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 35,			//ROS - Musculoskeletal
                'lookup_value_id' => 33,		//neck problem
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 35,			//ROS - Musculoskeletal
                'lookup_value_id' => 34,		//back problem
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 35,			//ROS - Musculoskeletal
                'lookup_value_id' => 35,		//Extremity Problem
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 35,			//ROS - Musculoskeletal
                'lookup_value_id' => 36,		//Joint problem
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - Integumentary
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 37,			//ROS - Integumentary
                'lookup_value_id' => 37,		//Rash
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 37,			//ROS - Integumentary
                'lookup_value_id' => 38,		//Bruise
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 37,			//ROS - Integumentary
                'lookup_value_id' => 39,		//Wound
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - Neurological
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 39,			//ROS - Neurological
                'lookup_value_id' => 40,		//Dizziness
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 39,			//ROS - Neurological
                'lookup_value_id' => 41,		//Weakness
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 39,			//ROS - Neurological
                'lookup_value_id' => 42,		//Numbness
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 39,			//ROS - Neurological
                'lookup_value_id' => 43,		//Confusion
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 39,			//ROS - Neurological
                'lookup_value_id' => 44,		//Headache
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 39,			//ROS - Neurological
                'lookup_value_id' => 45,		//Speech change
                'sort_order_number' => 6,
                'created_by' => 1
            )
        );
        //Inserting record for ROS - Psycological
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 41,			//ROS - Psycological
                'lookup_value_id' => 46,		//Depression
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 41,			//ROS - Psycological
                'lookup_value_id' => 47,		//Anxiety
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 41,			//ROS - Psycological
                'lookup_value_id' => 48,		//Suicidal Thoughts
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 41,			//ROS - Psycological
                'lookup_value_id' => 49,		//Suicidal Actions
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 41,			//ROS - Psycological
                'lookup_value_id' => 50,		//Sleep Changes
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 41,			//ROS - Psycological
                'lookup_value_id' => 51,		//Mood change
                'sort_order_number' => 6,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 43,         //ROS - Gastrointestinal
                'lookup_value_id' => 52,        //Abdominal Pain
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 43,         //ROS - Gastrointestinal
                'lookup_value_id' => 53,        //Nausea
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 43,         //ROS - Gastrointestinal
                'lookup_value_id' => 54,        //Vomiting
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 43,         //ROS - Gastrointestinal
                'lookup_value_id' => 55,        //Diarrhea
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 43,         //ROS - Gastrointestinal
                'lookup_value_id' => 56,        //Constipation
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 43,         //ROS - Gastrointestinal
                'lookup_value_id' => 57,        //Rectal Bleeding
                'sort_order_number' => 6,
                'created_by' => 1
            )
        );
        //Inserting record for PE - Constitution
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 45,			//PE - Constitution
                'lookup_value_id' => 58,		//Well Developed
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 45,			//PE - Constitution
                'lookup_value_id' => 59,		//No Distress
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        //Inserting record for PE - HENT
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 47,			//PE - HENT
                'lookup_value_id' => 60,		//Normocephalic
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 47,			//PE - HENT
                'lookup_value_id' => 61,		//Atraumatic
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 47,			//PE - HENT
                'lookup_value_id' => 62,		//Right ear normal
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 47,			//PE - HENT
                'lookup_value_id' => 63,		//Left ear normal
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 47,			//PE - HENT
                'lookup_value_id' => 64,		//Oropharynx clear
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 47,			//PE - HENT
                'lookup_value_id' => 65,		//Nose normal
                'sort_order_number' => 6,
                'created_by' => 1
            )
        );
        //Inserting record for PE - Eyes
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 49,			//PE - Eyes
                'lookup_value_id' => 66,		//PERRL
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 49,			//PE - Eyes
                'lookup_value_id' => 23,		//Discharge
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 49,			//PE - Eyes
                'lookup_value_id' => 24,		//Redness
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 49,			//PE - Eyes
                'lookup_value_id' => 67,		//EOM
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        //Inserting record for PE - Respiratory
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 51,			//PE - Respiratory
                'lookup_value_id' => 68,		//Normal lung sounds
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 51,			//PE - Respiratory
                'lookup_value_id' => 69,		//No Respiratory Distress
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 51,			//PE - Respiratory
                'lookup_value_id' => 30,		//Wheezing
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 51,			//PE - Respiratory
                'lookup_value_id' => 70,		//Rales
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 51,			//PE - Respiratory
                'lookup_value_id' => 71,		//Crackles
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        //Inserting record for PE - Cardiovascular
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 53,			//PE - Cardiovascular
                'lookup_value_id' => 72,		//Heart Rate WNL
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 53,			//PE - Cardiovascular
                'lookup_value_id' => 73,		//Heart Sounds WNL
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 53,			//PE - Cardiovascular
                'lookup_value_id' => 74,		//Heart Rhythm Regular
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 53,			//PE - Cardiovascular
                'lookup_value_id' => 75,		//Distal pulses intact
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        //Inserting record for PE - Musculoskeletal
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 55,			//PE - Musculoskeletal
                'lookup_value_id' => 76,		//Intact ROM
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 55,			//PE - Musculoskeletal
                'lookup_value_id' => 77,		//Normal Gait
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 55,			//PE - Musculoskeletal
                'lookup_value_id' => 78,		//Deformity
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 55,			//PE - Musculoskeletal
                'lookup_value_id' => 79,		//Tenderness
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 55,			//PE - Musculoskeletal
                'lookup_value_id' => 80,		//Swelling
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        //Inserting record for PE - Integumentary
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 57,			//PE - Integumentary
                'lookup_value_id' => 24,		//Redness
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 57,			//PE - Integumentary
                'lookup_value_id' => 39,		//Wounds
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 57,			//PE - Integumentary
                'lookup_value_id' => 81,		//Diaphoretic
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 57,			//PE - Integumentary
                'lookup_value_id' => 82,		//Pale
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        //Inserting record for PE - Neurological
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 59,			//PE - Neurological
                'lookup_value_id' => 83,		//Alert and Oriented x3
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 59,			//PE - Neurological
                'lookup_value_id' => 84,		//DTRs WNL
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 59,			//PE - Neurological
                'lookup_value_id' => 85,		//Cranial Nerve deficit
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 59,			//PE - Neurological
                'lookup_value_id' => 86,		//Weak Tone
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 59,			//PE - Neurological
                'lookup_value_id' => 87,		//Abnormal coordination
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        //Inserting record for PE - Psycological
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 61,			//PE - Psycological
                'lookup_value_id' => 88,		//Affect abnormal
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 61,			//PE - Psycological
                'lookup_value_id' => 89,		//Suicidal ideation
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 61,			//PE - Psycological
                'lookup_value_id' => 90,		//Aggitated
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 61,			//PE - Psycological
                'lookup_value_id' => 91,		//Anxious
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 63,         //PE - Gastrointestinal
                'lookup_value_id' => 92,        //Abdominal Tenderness
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 63,         //PE - Gastrointestinal
                'lookup_value_id' => 93,        //Distention
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 63,         //PE - Gastrointestinal
                'lookup_value_id' => 94,        //Bowel Sounds
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 63,         //PE - Gastrointestinal
                'lookup_value_id' => 95,        //Rectal Bleeding
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 63,         //PE - Gastrointestinal
                'lookup_value_id' => 96,        //Palpable Mass
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );

        //Inserting record for Disposition
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 67,			//Disposition
                'lookup_value_id' => 97,		//Discharged
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 67,			//Disposition
                'lookup_value_id' => 98,		//Admitted
                'sort_order_number' => 2,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 67,			//Disposition
                'lookup_value_id' => 99,		//Transferred
                'sort_order_number' => 3,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 67,			//Disposition
                'lookup_value_id' => 100,		//Expired
                'sort_order_number' => 4,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 67,			//Disposition
                'lookup_value_id' => 101,		//AMA
                'sort_order_number' => 5,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 67,			//Disposition
                'lookup_value_id' => 102,		//Eloped
                'sort_order_number' => 6,
                'created_by' => 1
            )
        );
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 67,			//Disposition
                'lookup_value_id' => 103,		//LWBS
                'sort_order_number' => 7,
                'created_by' => 1
            )
        );

        //Inserting record for ROS - Cardiovascular
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 33,			//ROS - Cardiovascular
                'lookup_value_id' => 104,		//Leg Swelling
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );

        //Inserting record for ROS - Integumentary
        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 37,			//ROS - Integumentary
                'lookup_value_id' => 105,		//Color Changes
                'sort_order_number' => 1,
                'created_by' => 1
            )
        );

        DB::table('doc_lookup_value')->insert(
            array(
                'doc_control_id' => 25,		//ROS - Constitution
                'lookup_value_id' => 15,		//Appetite
                'sort_order_number' => 6,
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
        Schema::dropIfExists('doc_lookup_value');
    }
}