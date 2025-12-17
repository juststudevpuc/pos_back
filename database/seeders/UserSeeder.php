<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
            'name' => 'sak',
            'email'=> 'sak@gmail.com',
            'password'=> Hash::make("pw12"),
            'role' => 'admin'
            ],
            [
            'name' => 'root',
            'email'=> 'root@gmail.com',
            'password'=> Hash::make("root"),
            'role' => 'user'
            ],
            [
            'name' => 'user',
            'email'=> 'user@gmail.com',
            'password'=> Hash::make("user"),
            'role' => 'user'
            ],
        ];
        foreach($users as $item){
            User::create($item);
        }

    }
}
