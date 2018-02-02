<?php

use Illuminate\Database\Seeder;

use App\Csvdata;


class med_lookup_valueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //clear out staging table
        DB::table('csv_data')->truncate();



        //Load tab-delimited file for medications
        if (($handle = fopen ( public_path('med_list.txt'), 'r' )) !== FALSE) {
            while ($data = fgetcsv ($handle, 1000, "\t"))  {

                $csv_data = new Csvdata ();
                $csv_data->medical_list = $data[0];
                $csv_data->save();

            }
            fclose ($handle);
        };


        //Load lookup_value
        $select_medlist = DB::table('csv_data')
            ->get(array('medical_list'));

        foreach($select_medlist as $data){
            DB::table('med_lookup_value')->insert(
                [
                    'med_lookup_value' => $data->medical_list,
                    'created_by'=>1
                ]);
        }


    }
}
