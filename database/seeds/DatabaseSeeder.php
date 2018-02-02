<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
			med_lookup_valueTableSeeder::class,
			diagnosis_lookup_valueTableSeeder::class,
			imaging_orders_lookup_valueTableSeeder::class,
			lab_orders_lookup_valueTableSeeder::class
		]);
    }
}
