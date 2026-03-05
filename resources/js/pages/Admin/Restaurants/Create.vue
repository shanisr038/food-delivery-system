<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Head } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({ cities: Array });

const form = useForm({
    restaurant_name: '',
    email: '',
    owner_name: '',
    city_id: '',
    address: '',
});
</script>

<template>
    <Head title="Create Restaurant" />
    <AuthenticatedLayout>
        <div class="py-12 max-w-2xl mx-auto">
            <form @submit.prevent="form.post(route('admin.restaurants.store'))" class="bg-white p-6 shadow rounded-lg space-y-4">
                <div>
                    <InputLabel value="Restaurant Name" />
                    <TextInput v-model="form.restaurant_name" class="w-full" />
                    <InputError :message="form.errors.restaurant_name" />
                </div>
                <div>
                    <InputLabel value="Owner Name" />
                    <TextInput v-model="form.owner_name" class="w-full" />
                    <InputError :message="form.errors.owner_name" />
                </div>
                <div>
                    <InputLabel value="Owner Email" />
                    <TextInput type="email" v-model="form.email" class="w-full" />
                    <InputError :message="form.errors.email" />
                </div>
                <div>
                    <InputLabel value="City" />
                    <SelectInput v-model="form.city_id" :options="cities" />
                    <InputError :message="form.errors.city_id" />
                </div>
                <div>
                    <InputLabel value="Address" />
                    <TextareaInput v-model="form.address" />
                    <InputError :message="form.errors.address" />
                </div>
                <PrimaryButton :disabled="form.processing">Save Restaurant</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>