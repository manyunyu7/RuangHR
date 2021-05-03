<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $this->insertDivisi('Divisi Produksi', null, null, $faker->safeEmailDomain, "089876553212", $faker->address);
        $this->insertDivisi('Divisi Finance', null, null, $faker->safeEmailDomain, "089876553213", $faker->address);
        $this->insertDivisi('Divisi Human Resource', null, null, $faker->safeEmailDomain, "089876553212", $faker->address);
        $this->insertDivisi('Divisi Sales', null, null, "089876553214", $faker->safeEmailDomain, $faker->address);
        $this->insertDivisi('Divisi Inti', null, null, "089876553215", $faker->safeEmailDomain, $faker->address);
        // $this->insertDivisi('Divisi Produksi', 1, 2,$faker->safeEmailDomain, "089876553212", $faker->address);
        // $this->insertDivisi('Divisi Finance', 3, 4,$faker->safeEmailDomain, "089876553213", $faker->address);
        // $this->insertDivisi('Divisi Human Resource', 5, 6,$faker->safeEmailDomain, "089876553212", $faker->address);
        // $this->insertDivisi('Divisi Sales', 7, 8, "089876553212",$faker->safeEmailDomain, $faker->address);
        // $this->insertDivisi('Divisi Inti', 9, 10, "089876553212",$faker->safeEmailDomain, $faker->address);
    }

    function insertDivisi($name, $lead_divisi, $co_lead, $kontak, $email, $alamat)
    {
        $data = new Divisi();
        $data->nama_divisi = $name;
        $data->lead_divisi = $lead_divisi;
        $data->co_lead_divisi = $co_lead;
        $data->kontak_divisi = $kontak;
        $data->email_divisi = $email;
        $data->alamat_divisi = $alamat;
        $data->save();
    }
}
