<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder_Partial extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
			med_lookup_valueTableSeeder_partial::class,
			diagnosis_lookup_valueTableSeeder_partial::class,
			imaging_orders_lookup_valueTableSeeder::class,
			lab_orders_lookup_valueTableSeeder::class
		]);
    }
}
