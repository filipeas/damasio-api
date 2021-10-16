<?php

use App\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'user',
                'email' => 'gestor_rdamasio@rdamasio.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
