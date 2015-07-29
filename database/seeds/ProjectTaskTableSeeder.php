<?php

use Illuminate\Database\Seeder;

class ProjectTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CursoLaravel\Entities\ProjectTask::truncate();
        factory(\CursoLaravel\Entities\ProjectTask::class, 50)->create();
    }
}
