<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'name' => 'Administrator',
            'email' => 'webb17@yandex.ru',
            'password' => bcrypt('admin'),
            'is_admin' => 1
        ]);
    }
}
