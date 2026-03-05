<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    categories: Array
});
</script>

<template>
    <Head title="Restaurant Menu" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Menu</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-8 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Categories & Products</h3>
                        <Link :href="route('vendor.categories.create')" class="bg-indigo-600 text-white px-4 py-2 rounded-md font-bold hover:bg-indigo-700">
                            + Add Category
                        </Link>
                    </div>

                    <div v-for="category in categories" :key="category.id" class="mb-8 border rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-center border-b pb-4 mb-4">
                            <h4 class="text-xl font-bold text-gray-800">{{ category.name }}</h4>
                            <div class="flex gap-4">
                                <Link :href="route('vendor.categories.edit', category.id)" class="text-blue-600 hover:underline text-sm">Edit Category</Link>
                                <Link :href="route('vendor.categories.destroy', category.id)" method="delete" as="button" class="text-red-600 hover:underline text-sm">Delete</Link>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div v-for="product in category.products" :key="product.id" class="flex justify-between items-center bg-white p-3 rounded shadow-sm border border-gray-100">
                                <div>
                                    <span class="font-medium text-gray-900">{{ product.name }}</span>
                                    <span class="ml-4 text-gray-500">${{ (product.price / 100).toFixed(2) }}</span>
                                </div>
                                <div class="flex gap-3">
                                    <Link :href="route('vendor.products.edit', product.id)" class="text-gray-400 hover:text-blue-600 text-sm">Edit</Link>
                                    <Link :href="route('vendor.products.destroy', product.id)" method="delete" as="button" class="text-gray-400 hover:text-red-600 text-sm">Delete</Link>
                                </div>
                            </div>
                            
                            <div class="pt-2">
                                <Link :href="route('vendor.products.create', { category_id: category.id })" class="text-indigo-600 text-sm font-bold hover:text-indigo-800">
                                    + Add Product to {{ category.name }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>