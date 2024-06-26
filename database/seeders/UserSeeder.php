<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(["email"=>"admin@techuplabs.com"],[
            "name"=>"admin","email"=>"admin@techuplabs.com",
            "password"=>bcrypt("12345678"),"email_verified_at"=>Carbon::now()
        ]);
    }
}
