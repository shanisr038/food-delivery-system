<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Role (Gets everything)
        $adminRole = Role::create(['name' => RoleName::ADMIN->value]);
        $adminRole->permissions()->sync(Permission::all());

        // 2. Vendor Role
        $this->createVendorRole();

        // 3. Customer Role
        $this->createCustomerRole();

        // 4. Staff Role
        $this->createStaffRole();
    }

    protected function createVendorRole(): void
    {
        $vendorRole = Role::create(['name' => RoleName::VENDOR->value]);

        $permissions = Permission::where('name', 'like', 'category.%')
            ->orWhere('name', 'like', 'product.%')
            ->orWhereIn('name', ['user.create', 'user.viewAny', 'user.delete', 'order.viewAny', 'order.update'])
            ->get();

        $vendorRole->permissions()->sync($permissions);
    }

    protected function createCustomerRole(): void
    {
        $customerRole = Role::create(['name' => RoleName::CUSTOMER->value]);

        $permissions = Permission::whereIn('name', [
            'cart.add',
            'order.create',
            'order.viewAny',
        ])->get();

        $customerRole->permissions()->sync($permissions);
    }

    protected function createStaffRole(): void
    {
        $staffRole = Role::create(['name' => RoleName::STAFF->value]);

        // Lesson 17 requirement: staff must be able to update orders
        $permissions = Permission::whereIn('name', [
            'order.viewAny',
            'order.update',
        ])->get();

        $staffRole->permissions()->sync($permissions);
    }
}