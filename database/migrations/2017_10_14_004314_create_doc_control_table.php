<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateDocControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_control', function (Blueprint $table) {
            $table->increments('doc_control_id');
            $table->integer('navigation_id')->unsigned();
            $table->string('label');
            $table->integer('doc_control_type_id')->unsigned();
            $table->integer('freetext_value_type_id')->unsigned()->nullable();
            $table->integer('doc_control_group')->nullable();
            $table->integer('doc_control_group_order')->nullable();
            $table->string('lookup_table_used')->nullable();
            $table->integer('freetext_minval_number')->nullable();
            $table->integer('freetext_maxval_number')->nullable();
            $table->date('freetext_minval_date')->nullable();
            $table->date('freetext_maxval_date')->nullable();
            $table->integer('freetext_minval_length')->nullable();
            $table->integer('freetext_maxval_length')->nullable();
            $table->boolean('archived')->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
//            $table->rememberToken();
            $table->timestamps();
        });
        //Adding foreign key constraint with navigation table
        Schema::table('doc_control', function (Blueprint $table) {
            $table->foreign('navigation_id')->references('navigation_id')->on('navigations');
        });
        //Adding foreign key constraint with doc_control_type table
        Schema::table('doc_control', function (Blueprint $table) {
            $table->foreign('doc_control_type_id')->references('doc_control_type_id')->on('doc_control_type');
        });
        //Adding foreign key constraint with freetext_value_type table
        Schema::table('doc_control', function (Blueprint $table) {
            $table->foreign('freetext_value_type_id')->references('freetext_value_type_id')->on('freetext_value_type');
        });
        /*Demographics has been removed as part of the active record
                //Inserting record for demographic-gender
                DB::table('doc_control')->insert(
                    array(
                        'navigation_id' => ?,  //Demographics
                        'label' => 'sex',
                        'doc_control_type_id' => 1,   //radio
                        'created_by' => 1
                        )
                    );
                //Inserting record for demographic-age
                DB::table('doc_control')->insert(
                    array(
                        'navigation_id' => ?,   //Demographics
                        'label' => 'age',
                        'doc_control_type_id' => 3,   //freeform text
                        'freetext_value_type_id' => 1,    //numerical
                        'created_by' => 1
                        )
                    );
                //Inserting record for demographic-height
                DB::table('doc_control')->insert(
                    array(
                        'navigation_id' => ?,     //Demographics
                        'label' => 'height',
                        'doc_control_type_id' => 3,     //Freeform text
                        'freetext_value_type_id' => 3,    //Character
                        'created_by' => 1
                        )
                    );
                //Inserting record for demographic-weight
                DB::table('doc_control')->insert(
                    array(
                        'navigation_id' => ?,   //Demographics
                        'label' => 'weight',
                        'doc_control_type_id' => 3,    //freeform text
                        'freetext_value_type_id' => 3,   //character
                        'created_by' => 1
                        )
                    );
        */
        //Insert records for History of Present Illness
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 1,   		//History of Present Illness
                'label' => 'History of Present Illness',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 1,   		//History of Present Illness
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        //Insert records for Personal History
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 3,   		//Personal History
                'label' => 'Diagnosis History',
                'doc_control_type_id' => 5,  	//Search bar
//			'doc_control_type_id' => 4,  	//Dropdown
                'lookup_table_used' => 'diagnosis_lookup_value',
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 3,   		//Personal History
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        //Insert records for Family History
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 4,   		//Family History
                'label' => 'Family Member',
                'doc_control_type_id' => 3,  	//Freeform text
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'doc_control_group' => 1,		//Group 1
                'doc_control_group_order' => 1,	//Group order 1
                'created_by' => 1				//admin
            )
        );
        //Insert records for Family History
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 4,   		//Family History
                'label' => 'Family Member Diagnosis',
                'doc_control_type_id' => 5,  	//Search bar
//			'doc_control_type_id' => 4,  	//Dropdown
                'lookup_table_used' => 'diagnosis_lookup_value',
                'freetext_value_type_id' => 3,  //character
                'doc_control_group' => 1,		//Group 1
                'doc_control_group_order' => 2,	//Group order 2
                'created_by' => 1				//admin
            )
        );
        //Insert records for Family History
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 4,   		//Family History
                'label' => 'Family Member Status',
                'doc_control_type_id' => 1 , 	//radio
                'lookup_table_used' => 'lookup_value',
                'doc_control_group' => 1,		//Group 1
                'doc_control_group_order' => 3,	//Group order 3
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 4,   		//Family History
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        //Insert records for Surgical History
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 5,   		//Surgical History
                'label' => 'Surgical History',
                'doc_control_type_id' => 5,  	//Search bar
//			'doc_control_type_id' => 4,  	//Dropdown
                'lookup_table_used' => 'diagnosis_lookup_value',
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 5,   		//Surgical History
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        //Insert records for Social History
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 6,   		//Social History
                'label' => 'Smoke Tobacco',
                'doc_control_type_id' => 1 , 	//radio
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 6,   		//Social History
                'label' => 'Non-Smoke Tobacco',
                'doc_control_type_id' => 1,  	//radio
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 6,   		//Social History
                'label' => 'Drink Alcohol',
                'doc_control_type_id' => 1,  	//radio
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 6,   		//Social History
                'label' => 'Sexual Activity',
                'doc_control_type_id' => 1,  	//radio
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 6,   		//Social History
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        //Insert records for Medications
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 7,   		//Medications
                'label' => 'Medications',
                'doc_control_type_id' => 5,  	//Search bar
//			'doc_control_type_id' => 4,  	//Dropdown
                'lookup_table_used' => 'med_lookup_value',
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 7,   		//Medications
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        //Insert records for Vital Signs
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Blood Pressure (BP) Systolic',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Blood Pressure (BP) Diastolic',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Heart Rate (HR)',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Respiratory Rate',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Temperature (Temp) (F)',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
//Removing height and weight from vitals as it is stored in patient table
//		DB::table('doc_control')->insert (
//			array (
//			'navigation_id' => 8,   		//Vital Signs
//			'label' => 'Weight (Wt) (Kg)',
//			'doc_control_type_id' => 5,  	//Search bar
////			'doc_control_type_id' => 4,  	//Dropdown
//			'freetext_value_type_id' => 3,  //character
//			'created_by' => 1				//admin
//			)
//		);
//
//		DB::table('doc_control')->insert (
//			array (
//			'navigation_id' => 8,   		//Vital Signs
//			'label' => 'Height (Ht) (Cm)',
//			'doc_control_type_id' => 5,  	//Search bar
////			'doc_control_type_id' => 4,  	//Dropdown
//			'freetext_value_type_id' => 3,  //character
//			'created_by' => 1				//admin
//			)
//		);
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Pain',
                'doc_control_type_id' => 3,  	//Freeform text
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 10,   		//Constitution
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 10,   		//Constitution
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 11,   		//HENT
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 11,   		//HENT
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 12,   		//Eyes
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 12,   		//Eyes
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 13,   		//Respiratory
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 13,   		//Respiratory
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 14,   		//Cardiovascular
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 14,   		//Cardiovascular
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 15,   		//Musculoskeletal
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 15,   		//Musculoskeletal
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 16,   		//Integumentary
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 16,   		//Integumentary
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 17,   		//Neurological
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 17,   		//Neurological
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 18,   		//Psychological
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 18,   		//Psychological
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 19,           //ROS-Gastrointestinal
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1               //admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 19,           //ROS-Gastrointestinal
                'label' => 'Comments',
                'doc_control_type_id' => 3,
                'freetext_value_type_id' => 3,
                'created_by' => 1               //admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 21,   		//Constitution
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 21,   		//Constitution
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 22,   		//HENT
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 22,   		//HENT
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 23,   		//Eyes
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 23,   		//Eyes
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 24,   		//Respiratory
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 24,   		//Respiratory
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 25,   		//Cardiovascular
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 25,   		//Cardiovascular
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 26,   		//Musculoskeletal
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 26,   		//Musculoskeletal
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 27,   		//Integumentary
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 27,   		//Integumentary
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 28,   		//Neurological
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 28,   		//Neurological
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 29,   		//Psychological
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,  	//Checkbox
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 29,   		//Psychological
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 30,           //PE-Gastrointestinal
                'label' => 'Symptoms',
                'doc_control_type_id' => 2,
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1               //admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 30,           //PE-Gastrointestinal
                'label' => 'Comments',
                'doc_control_type_id' => 3,
                'freetext_value_type_id' => 3,
                'created_by' => 1               //admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 33,   		//MDM/Plan
                'label' => 'Plan',
                'doc_control_type_id' => 3,  	//Checkbox
                'freetext_value_type_id' => 3,	//character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 33,   		//MDM/Plan
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 34,   		//Disposition
                'label' => 'Disposition',
                'doc_control_type_id' => 1,  	//Radio
                'lookup_table_used' => 'lookup_value',
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 34,   		//Disposition
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//Freeform text
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        //Additional Vital Signs documentation controls
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Oxygen Saturation',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Vital_Timestamp',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 32,   		//Results
                'label' => 'Order Results',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 32,   		//Results
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 31,   		//Order
                'label' => 'Lab Orders',
                'doc_control_type_id' => 5,  	//Search bar
//			'doc_control_type_id' => 4,  	//Dropdown
                'lookup_table_used' => 'lab_orders_lookup_value',
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 31,   		//Order
                'label' => 'Imaging Orders',
                'doc_control_type_id' => 5,  	//Search bar
//			'doc_control_type_id' => 4,  	//Dropdown
                'lookup_table_used' => 'imaging_orders_lookup_value',
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        //This is just in case
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 31,   		//Order
                'label' => 'Comments',
                'doc_control_type_id' => 3,  	//freetext
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Weight (Wt) (Kg)',
                'doc_control_type_id' => 3,  	//Search bar
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
            )
        );
        DB::table('doc_control')->insert (
            array (
                'navigation_id' => 8,   		//Vital Signs
                'label' => 'Height (Ht) (Cm)',
                'doc_control_type_id' => 3,  	//Search bar
//			'doc_control_type_id' => 4,  	//Dropdown
                'freetext_value_type_id' => 3,  //character
                'created_by' => 1				//admin
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
        Schema::dropIfExists('doc_control');
    }
}