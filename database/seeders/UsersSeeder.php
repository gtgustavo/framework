<?php

use Carbon\Carbon;
use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = array(
            array(
                'name'       => 'Admin',
                'phone'      => '04124110314',
                'id_card'    => '12345678',
                'email'      => 'admin@admin.com',
                'password'   => '$2y$10$ZWtsPGnUnwL/woUT66TkwuCMnp6vyTNsCRkmvdO0GR4.xUlV2oecG', //gt123456
                'role'       => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            )
        );

        $users = $this->table('users');

        $users->insert($data)->save();
    }
}
