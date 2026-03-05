<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({ product: Object, categories: Array });

// Divide price by 100 to show dollars to the user
const form = useForm({
    category_id: props.product.category_id,
    name: props.product.name,
    price: (props.product.price / 100).toFixed(2)
});
</script>

<template>
    <Head title="Edit Product" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Edit {{ product.name }}</h2></template>
        <div class="py-12 max-w-lg mx-auto">
            <form @submit.prevent="form.patch(route('vendor.products.update', props.product.id))" class="bg-white p-6 rounded shadow space-y-4">
                <select v-model="form.category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
                <TextInput v-model="form.name" type="text" class="w-full" />
                <TextInput v-model="form.price" type="number" step="0.01" class="w-full" />
                <PrimaryButton>Update Product</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>