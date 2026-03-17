<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Membuat role admin
        $adminRole = new Role();
        $adminRole->name = "admin";
        $adminRole->display_name = "Admin";
        $adminRole->save();
        // Membuat role member
        $memberRole = new Role();
        $memberRole->name = "user";
        $memberRole->display_name = "User";
        $memberRole->save();
        // Membuat sample admin
        $admin = new User();
        $admin->name = 'Admin Larapus';
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('12345678');
        $admin->save();
        $admin->attachRole($adminRole);
        // Membuat sample member
        $member = new User();
        $member->name = "Sample Member";
        $member->email = 'user@user.com';
        $member->password = bcrypt('12345678');
        $member->save();
        $member->attachRole($memberRole);
    }
}
