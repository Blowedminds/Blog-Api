<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTable extends Seeder
{
    public $entries;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->entries['user'] = new User([
          'user_id' => uniqid('user'),
          'name' => 'Ruzga',
          'email' => 'ruzga@gmail.com',
          'password' => '$2y$10$R2F7UyN9.4z4fBOO3oV5juSUj.rK.LqXixT5sL6FCxLI5wrSmTLmm'
        ]);
    }
}
