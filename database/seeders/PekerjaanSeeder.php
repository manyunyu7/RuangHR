<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        DB::table('pekerjaan')->insert([
            'nama_pekerjaan' => $faker->jobName,
            'gaji' => $faker->salary,
            'created_at' =>  \Carbon\Carbon::yesterday(),
    		'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
