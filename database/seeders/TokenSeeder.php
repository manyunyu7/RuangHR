<?php

namespace Database\Seeders;

use App\Models\Token;
use Illuminate\Database\Seeder;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertUser("Master HR",1,"n0l5KB7Eg7gkc8Fc7y0GsXKY");
        $this->insertUser("Logistik",2,"CuwsUTTc1EhWknGqhP9SB3Qd");
        $this->insertUser("Sales",2,"ECZbnNJAh70qIU0srIcKEB9q");
        $this->insertUser("Finance",2,"guB5jO7kd3ubFJD9RBbaIDUM");
    }

    function insertUser($name,$access_type,$token){
        $data = new Token();
        $data->name = $name;
        $data->access_type = $access_type;
        $data->token = $token;
        $data->save();
    }
}
