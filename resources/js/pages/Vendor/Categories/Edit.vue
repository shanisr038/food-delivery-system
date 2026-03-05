<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({ category: Object });
const form = useForm({ name: props.category.name });
</script>

<template>
    <Head title="Edit Category" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Edit {{ category.name }}</h2></template>
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
            <form @submit.prevent="form.patch(route('vendor.categories.update', props.category.id))" class="bg-white p-6 rounded shadow max-w-md mx-auto">
                <TextInput v-model="form.name" type="text" class="w-full" />
                <PrimaryButton class="mt-4">Update</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>