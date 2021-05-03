<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
 
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class KaryawanSeederSecondary extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for($i = 1; $i <= 5000; $i++){
            $gender = $faker->randomElement(['1', '2']);
			$divisi=null;
			if ($i>10) {
				$divisi = $faker->randomElement([1,2,3,4,5]);
			}

    		DB::table('pegawai')->insert([
    			'nama_depan' => $faker->firstName,
    			'nama_belakang' => $faker->lastName,
    			'email' => $faker->freeEmail,
    			'no_hp' => $faker->phoneNumber,
    			'alamat' => $faker->address,
    			'photo_path' => null,
    			'tanggal_masuk' => $faker->dateTimeBetween($startDate = '-10 years', $endDate = '-1 years', $timezone = null) ,
    			'tanggal_lahir' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = '-25 years', $timezone = null) ,
    			'gender' => $gender,
    			'id_pekerjaan' => null,
    			'id_divisi' => $divisi,
    			'created_at' =>  \Carbon\Carbon::yesterday(),
    			'updated_at' => \Carbon\Carbon::now(),
    		]);
 
    	}
    }
}
