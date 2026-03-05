<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({ categories: Array, category_id: String });
const form = useForm({
    category_id: props.category_id || '',
    name: '',
    price: ''
});
</script>

<template>
    <Head title="Add Product" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold text-center">Add Product</h2></template>
        <div class="py-12 max-w-lg mx-auto">
            <form @submit.prevent="form.post(route('vendor.products.store'))" class="bg-white p-6 rounded shadow space-y-4">
                <div>
                    <InputLabel value="Category" />
                    <select v-model="form.category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select Category</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                </div>
                <div>
                    <InputLabel value="Name" />
                    <TextInput v-model="form.name" type="text" class="w-full" required />
                </div>
                <div>
                    <InputLabel value="Price ($)" />
                    <TextInput v-model="form.price" type="number" step="0.01" class="w-full" required />
                </div>
                <PrimaryButton>Save Product</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>