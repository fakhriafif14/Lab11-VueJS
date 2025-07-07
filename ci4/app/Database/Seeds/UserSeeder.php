<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = model('UserModel');
        $model->insert([
            'username'      => 'admin',
            'useremail'     => 'admin@gmail.com',
            'userpassword'  => password_hash('12345', PASSWORD_DEFAULT),
        ]);
    }
}
