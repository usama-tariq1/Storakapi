<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // Only For Default Users
        
        // $role = new Role ;
        // $role->truncate();
        // $user = new User;
        // $user->truncate(); 


        // Role::insert(
        //     [
        //         [
        //             "name" => "SuperAdmin",
                    
    
        //         ],
        //         [
        //             "name" => "Admin",
                    
                    
        //         ],
        //         [
        //             "name" => "Vendor",
                    
                    
        //         ],
        //         [
        //             "name" => "User",
                    
                    
        //         ]
        //     ]
        // );


        // User::insert(
        //     [
        //         [
        //             'name' => 'Super Admin',
        //             'email' => 'admin@gmail.com',
        //             'role_id' => '1',
        //             'password' => Hash::make('12345678'),
        //         ],
        //         [
        //             'name' => 'Vendor',
        //             'email' => 'vendor@gmail.com',
        //             'role_id' => '3',
        //             'password' => Hash::make('12345678'),
        //         ],
        //         [
        //             'name' => 'User',
        //             'email' => 'user@gmail.com',
        //             'role_id' => '4',
        //             'password' => Hash::make('12345678'),
        //         ],
        //     ]
        // );





    }
}
