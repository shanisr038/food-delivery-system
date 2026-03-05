<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    orders: Array
});

const getStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'preparing': 'bg-blue-100 text-blue-800',
        'ready': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};
</script>

<template>
    <Head title="My Orders" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Order History</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div v-if="orders.length > 0" class="space-y-6">
                    <div v-for="order in orders" :key="order.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                        <div class="p-6">
                            <div class="flex justify-between items-start border-b pb-4 mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Order #{{ order.id }}</h3>
                                    <p class="text-sm text-gray-500">{{ order.restaurant.name }}</p>
                                    <p class="text-xs text-gray-400">{{ new Date(order.created_at).toLocaleString() }}</p>
                                </div>
                                <div class="text-right">
                                    <span :class="['px-3 py-1 rounded-full text-xs font-bold uppercase', getStatusClass(order.status)]">
                                        {{ order.status }}
                                    </span>
                                    <div class="mt-2 font-bold text-lg text-indigo-600">
                                        ${{ (order.total / 100).toFixed(2) }}
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div v-for="item in order.products" :key="item.id" class="flex justify-between text-sm text-gray-600">
                                    <span>{{ item.name }}</span>
                                    <span>${{ (item.price / 100).toFixed(2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-12 bg-white rounded-lg shadow">
                    <p class="text-gray-500 italic">You haven't placed any orders yet.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>