<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CursoLaravel\Entities\Client::truncate();
        factory(\CursoLaravel\Entities\Client::class, 10)->create();
    }
}
