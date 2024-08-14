<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'user' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'user_number' => 1,
                'job' => 'Administrador',
                'status' => 'activo',
                'level' => 1,
            ],[
                'user' => 'usuario',
                'email' => 'usuario@gmail.com',
                'password' => Hash::make('123'),
                'user_number' => 2,
                'job' => 'Cosechador',
                'status' => 'activo',
                'level' => 2,
            ]
            ];
            DB::table('users')->insert($users);
        }
    }

