<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin
        Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'This Role Can Conrtol Entire App',
            'rank' => 99
        ]);

        //author
        Role::create([
            'name' => 'Author',
            'slug' => 'author',
            'description' => 'This Role Can Manage Book Section',
            'rank' => 50
        ]);
    }
}
