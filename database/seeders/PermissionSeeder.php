<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bütün icazələri yarat
        Permission::create(['name' => 'everything', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit-posts', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete-posts', 'guard_name' => 'web']);
        Permission::create(['name' => 'view-users', 'guard_name' => 'web']);
        Permission::create(['name' => 'create-users', 'guard_name' => 'web']);
        Permission::create(['name' => 'edit-users', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete-users', 'guard_name' => 'web']);
        // Burada daha çox icazə əlavə edə bilərsən.
    }
}
