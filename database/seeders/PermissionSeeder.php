<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $actions = ['viewAny', 'view', 'create', 'update', 'delete'];
        $resources = ['user','restaurant', 'category', 'product','order'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::create(['name' => "{$resource}.{$action}"]);
            }
        }

        // Add this line at the very bottom of the run method
        Permission::create(['name' => 'cart.add']);
    }
}