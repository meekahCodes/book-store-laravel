<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $admin_role = Role::where('slug', '=', 'admin')->first();
       $author_role = Role::where('slug', '=', 'author')->first();


       //create admin user
       $user = User::factory()->create([
           'name' => 'admin',
           'email' => 'admin@gmail.com'
       ]);

       UserRole::create([
           'user_id' => $user->id,
           'role_id' => $admin_role->id
       ]);


       for ($i=0; $i < 5 ; $i++) { 
            $user = User::factory()->create();

            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $author_role->id
            ]);
       }


    }
}
