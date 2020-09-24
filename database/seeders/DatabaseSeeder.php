<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nama' => ('Ardabilli'),
            'username' => ('Billi'),
            'email' => Str::random(10).'@gmail.com',
            'no_hp' => ('089900920019'),
            'alamat' => ('Malang Jawa timur'),
            'desc' => ('ini cuma test'),
            'role' => (1),
            'password' => ('password'),
        ]);
    }
}
