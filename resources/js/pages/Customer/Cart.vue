<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const page = usePage();
const form = useForm({});
const orderForm = useForm({});

const removeProduct = (uuid) => {
    form.post(route('customer.cart.remove', uuid), { preserveScroll: true });
};

const submitOrder = () => {
    orderForm.post(route('customer.orders.store'));
};
</script>

<template>
    <Head title="My Cart" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Shopping Cart</h2>
        </template>

        <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div v-if="page.props.cart.items.length > 0">
                    <div v-for="item in page.props.cart.items" :key="item.uuid" class="flex justify-between items-center border-b py-4">
                        <div>
                            <div class="font-bold">{{ item.name }}</div>
                            <div class="text-sm text-gray-600">${{ (item.price / 100).toFixed(2) }}</div>
                        </div>
                        <button @click="removeProduct(item.uuid)" class="text-red-600 text-sm">Remove</button>
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <div class="flex justify-between text-xl font-bold mb-6">
                            <span>Total</span>
                            <span>${{ (page.props.cart.total / 100).toFixed(2) }}</span>
                        </div>

                        <PrimaryButton 
                            @click="submitOrder" 
                            class="w-full justify-center py-4"
                            :disabled="orderForm.processing"
                        >
                            Place Order
                        </PrimaryButton>
                    </div>
                </div>

                <div v-else class="text-center py-12 text-gray-500">
                    Your cart is empty.
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>