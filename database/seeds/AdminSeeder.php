<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'najmun',
            'email' => 'najmn@gmail.com',
            'password' => bcrypt('123'),
            'role' => 'administrator'
        ]);
    }
}
