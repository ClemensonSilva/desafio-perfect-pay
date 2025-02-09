<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::factory(5)->create();
        $password1 = crypted('atum1234');
        $password2 = crypted('salmao12');
        // usuario para teste
        Users::factory()->create([
            'name' => 'Cristiano Messi',
            'email' => 'cristianomessi@gmail.com',
            'role_id' => 1,
            'joined_date' => '2021-01-01',
            'password' => $password1, // password
        ]);
        Users::factory()->create([

            'name' => 'Neymar Mbappe',
            'email' => 'neymarmbappe@gmail.com',
            'role_id' => 2,
            'joined_date' => '2021-01-01',
            'password' => $password2, // password
        ]);
    }
}
