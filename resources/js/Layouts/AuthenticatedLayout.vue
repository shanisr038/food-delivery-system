<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('home')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                            </Link>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink :href="route('home')" :active="route().current('home')">
                                Home
                            </NavLink>
                            
                            <NavLink v-if="can('restaurant.viewAny')" :href="route('admin.restaurants.index')" :active="route().current('admin.restaurants.index')">
                                Restaurants
                            </NavLink>
                            
                            <NavLink v-if="can('category.viewAny')" :href="route('vendor.menu')" :active="route().current('vendor.menu')">
                                Restaurant Menu
                            </NavLink>
                            <NavLink 
    v-if="can('user.create') && $page.props.auth.is_vendor" 
    :href="route('vendor.staff-members.index')" 
    :active="route().current('vendor.staff-members.index')"
>
    Staff Management
</NavLink>
<NavLink
    v-if="can('order.update')"
    :href="route('staff.orders.index')"
    :active="route().current('staff.orders.index')"
>
    Restaurant Orders
</NavLink>
     <NavLink 
    v-if="can('order.viewAny')" 
    :href="route('customer.orders.index')" 
    :active="route().current('customer.orders.index')"
>
    My Orders
</NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <div v-if="!$page.props.auth.user" class="flex gap-4">
                            <Link :href="route('login')" class="text-sm text-gray-700 underline">Log in</Link>
                            <Link :href="route('register')" class="text-sm text-gray-700 underline">Register</Link>
                        </div>

                        <div v-else class="flex items-center gap-4">
                            <Link
                                v-if="can('cart.add')"
                                :href="route('customer.cart.index')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150"
                            >
                                View basket ${{ ($page.props.cart.total / 100).toFixed(2) }}
                            </Link>

                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                                {{ $page.props.auth.user.name }}
                                                <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button"> Log Out </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <header class="bg-white shadow" v-if="$slots.header">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main>
            <div v-if="$page.props.status" class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ $page.props.status }}
                </div>
            </div>
            
            <div v-if="$page.props.errors.message" class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ $page.props.errors.message }}
                </div>
            </div>

            <slot />
        </main>
    </div>
</template>