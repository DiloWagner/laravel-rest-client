<?php

use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CursoLaravel\Entities\Project::truncate();
        factory(\CursoLaravel\Entities\Project::class, 10)->create();
    }
}
