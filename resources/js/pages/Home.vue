<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ restaurants: Array });
</script>

<template>
    <Head title="Home" />
    <AuthenticatedLayout>
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div v-for="restaurant in restaurants" :key="restaurant.id" class="bg-white overflow-hidden shadow-sm rounded-xl p-4">
                    <img :src="`https://picsum.photos/seed/${restaurant.id}/400/250`" class="rounded-lg mb-4" />
                    <Link :href="route('restaurant', restaurant.id)" class="text-xl font-bold hover:text-indigo-600">
                        {{ restaurant.name }}
                    </Link>
                    <p class="text-gray-500 text-sm">{{ restaurant.address }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>