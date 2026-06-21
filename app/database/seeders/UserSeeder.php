<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::create([
        'name'=>'Admin',
        'email'=>'admin@dev.com',
        'password'=>'12345678',
        'username'=>'admin'
       ]);
       $user = User::first();
       $user->assignRole(Role::findById(1, 'web'));
    }
}
