<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CursoLaravel\Entities\User::truncate();
        //factory(\CursoLaravel\Entities\User::class, 10)->create();
    }
}
