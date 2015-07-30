<?php

use Illuminate\Database\Seeder;

class ProjectMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CursoLaravel\Entities\ProjectMembers::truncate();
        factory(\CursoLaravel\Entities\ProjectMembers::class, 5)->create();
    }
}
