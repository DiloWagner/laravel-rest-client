<?php

use Illuminate\Database\Seeder;

class ProjectNoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CursoLaravel\Entities\ProjectNote::truncate();
        factory(\CursoLaravel\Entities\ProjectNote::class, 50)->create();
    }
}
