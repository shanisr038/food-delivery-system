<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({ name: '' });
</script>

<template>
    <Head title="Add Category" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">New Category</h2></template>
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg max-w-md">
                <form @submit.prevent="form.post(route('vendor.categories.store'))">
                    <InputLabel value="Name" />
                    <TextInput v-model="form.name" type="text" class="w-full mt-1" required />
                    <InputError :message="form.errors.name" class="mt-2" />
                    <PrimaryButton class="mt-4" :disabled="form.processing">Save</PrimaryButton>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>