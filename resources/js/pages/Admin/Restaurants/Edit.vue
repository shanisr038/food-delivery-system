<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Head } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    restaurant: Object,
    cities: Array
});

const form = useForm({
    restaurant_name: props.restaurant.name,
    city: props.restaurant.city_id,
    address: props.restaurant.address,
});
</script>

<template>
    <Head :title="'Edit ' + restaurant.name" />
    <AuthenticatedLayout>
        <div class="py-12 max-w-2xl mx-auto">
            <form @submit.prevent="form.patch(route('admin.restaurants.update', props.restaurant.id))" 
                  class="bg-white p-6 shadow rounded-lg space-y-4">
                
                <div>
                    <InputLabel value="Restaurant Name" />
                    <TextInput v-model="form.restaurant_name" class="w-full" />
                    <InputError :message="form.errors.restaurant_name" />
                </div>

                <div>
                    <InputLabel value="City" />
                    <SelectInput v-model="form.city" :options="cities" />
                    <InputError :message="form.errors.city" />
                </div>

                <div>
                    <InputLabel value="Address" />
                    <TextareaInput v-model="form.address" />
                    <InputError :message="form.errors.address" />
                </div>

                <PrimaryButton :disabled="form.processing">Update Restaurant</PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>