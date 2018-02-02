<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateLookupValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lookup_value', function (Blueprint $table) {
            $table->increments('lookup_value_id');
            $table->string('lookup_value');
            $table->boolean('archived')->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
//            $table->rememberToken();
            $table->timestamps();
        });
        //Inserting record for male 1
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Male',
                'created_by' => 1
            )
        );
        //Inserting record for female 2
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Female',
                'created_by' => 1
            )
        );
        //Inserting record for YES 3
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'YES',
                'created_by' => 1
            )
        );
        //Inserting record for NO 4
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'NO',
                'created_by' => 1
            )
        );
        //Inserting record for active 5
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Active',
                'created_by' => 1
            )
        );
        //Inserting record for not active 6
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Not Active',
                'created_by' => 1
            )
        );
        //Inserting record for active 7
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Alive',
                'created_by' => 1
            )
        );
        //Inserting record for not active 8
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Deceased',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - Constitutional
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Fever',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Chills',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Fatigue',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Weight Changes - Gain',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Weight Changes - Loss',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Activity Changes',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Appetite',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - HENT
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Runny Nose',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Congestion',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Sneezing',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Dental Problem',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Ear Problem',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Throat | Mouth Problem',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Nose Problem',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - Eyes
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Discharge',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Redness',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Pain',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Visual Changes',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - Respiratory
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Cough',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Shortness of Breath (SOB)',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Chest Pressure | Tightness',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Wheezing',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - Cardiovascular
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Chest Pain',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Palpitations',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - Musculoskeletal
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Neck Problem',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Back Problem',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Extremity Problem',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Joint Problem',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - Integumentary
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Rash',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Bruise',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Wound',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - Neurological
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Dizziness',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Weakness',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Numbness',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Confusion',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Headache',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Speech Changes',
                'created_by' => 1
            )
        );
        //Inserting records for ROS - Psychological
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Depression',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Anxiety',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Suicidal Thoughts',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Suicidal Actions',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Sleep Changes',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Mood Changes',
                'created_by' => 1
            )
        );

        //Inserting records for ROS - Gastrointestinal
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Abdominal Pain',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Nausea',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Vomiting',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Diarrhea',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Constipation',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Rectal Bleeding',
                'created_by' => 1
            )
        );
        //Inserting records for PE - Constitutional
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Well Developed',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'No Distress',
                'created_by' => 1
            )
        );
        //Inserting records for PE - HENT
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Normocephalic',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Atraumatic',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Right Ear Normal',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Left Ear Normal',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Oropharynx Clear',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Nose Normal',
                'created_by' => 1
            )
        );
        //Inserting records for PE - Eyes
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'PERRL',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'EOM',
                'created_by' => 1
            )
        );
        //Inserting records for PE - Respiratory
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Normal Lung Sounds',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'No Respiratory Distress',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Rales',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Crackles',
                'created_by' => 1
            )
        );
        //Inserting records for PE - Cardiovascular
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Heart Rate WNL',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Heart Sounds WNL',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Heart Rhythm Regular',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Distal Pulses Intact',
                'created_by' => 1
            )
        );
        //Inserting records for PE - Musculoskeletal
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Intact ROM',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Normal Gait',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Deformity',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Tenderness',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Swelling',
                'created_by' => 1
            )
        );
        //Inserting records for PE - Integumentary
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Diaphoretic',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Pale',
                'created_by' => 1
            )
        );
        //Inserting records for PE - Neurological
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Alert and Oriented x3',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'DTRs WNL',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Cranial Nerve Deficit',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Weak Tone',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Abnormal Coordination',
                'created_by' => 1
            )
        );
        //Inserting records for PE - Psychological
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Affect Abnormal',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Suicidal Ideation',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Aggitated',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Anxious',
                'created_by' => 1
            )
        );

        //Inserting records for PE - Gastrointestinal
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Abdominal Tenderness',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Distention',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Bowel Sounds WNL',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Rectal Bleeding',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Palpable Mass',
                'created_by' => 1
            )
        );
        //Inserting records for Disposition
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Discharged',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Admitted',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Transferred',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Expired',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'AMA',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Eloped',
                'created_by' => 1
            )
        );
        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'LWBS',
                'created_by' => 1
            )
        );

        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Leg Swelling',
                'created_by' => 1
            )
        );

        DB::table('lookup_value')->insert(
            array(
                'lookup_value' => 'Color Changes',
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
        Schema::dropIfExists('lookup_value');
    }
}