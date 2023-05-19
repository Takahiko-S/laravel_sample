<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;



class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $init_users =[
            [
                'name' => '管理者',
                'email' => 'webmaster@localhost.localdomain',
                'password' => 'P@ssw0rd#2023'
            ],
            [
                'name' => '管理ユーザー',
                'email' => 'test@localhost.localdomain',
                'password' => 'P@ssw0rd#2023'
            ],
        ];
        
        foreach($init_users as $user){
            $data = new Admin();
            $data->name = $user['name'];
            $data->email = $user['email'];
            $data->password = Hash::make($user['password']);
            $data->save();
        }
    }
}
