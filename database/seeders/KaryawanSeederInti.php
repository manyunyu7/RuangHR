<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class KaryawanSeederInti extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create('id_ID');

		for ($i = 1; $i <= 10; $i++) {
			$gender = $faker->randomElement(['1', '2']);
			$divisi = 0;

			if ($i = 1 || $i = 2) {
				$divisi = 1;
			}
			if ($i = 3 || $i = 4) {
				$divisi = 2;
			}
			if ($i = 5 || $i = 6) {
				$divisi = 3;
			}
			if ($i = 7 || $i = 8) {
				$divisi = 4;
			}
			if ($i = 9 || $i = 10) {
				$divisi = 5;
			}

			DB::table('pegawai')->insert([
				'nama_depan' => $faker->firstName,
				'nama_belakang' => $faker->lastName,
				'email' => $faker->freeEmail,
				'no_hp' => $faker->phoneNumber,
				'alamat' => $faker->address,
				'photo_path' => null,
				'tanggal_masuk' => $faker->dateTimeBetween($startDate = '-10 years', $endDate = '-1 years', $timezone = null),
				'tanggal_lahir' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = '-25 years', $timezone = null),
				'gender' => $gender,
				'id_pekerjaan' => null,
				'id_divisi' => $divisi,
				'created_at' =>  \Carbon\Carbon::yesterday(),
				'updated_at' => \Carbon\Carbon::now(),
			]);
		}
	}
}
