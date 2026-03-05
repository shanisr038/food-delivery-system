<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3';

defineProps({
  restaurants: Array
})

const deleteRestaurant = (id) => {
  if (confirm('Are you sure you want to delete this restaurant? This action cannot be undone and will remove all associated menu items.')) {
    router.delete(route('admin.restaurants.destroy', id), {
      preserveScroll: true,
    });
  }
}
</script>

<template>
  <Head title="Restaurants" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Restaurants</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          
          <div class="mb-6">
            <Link 
              v-if="can('restaurant.create')" 
              :href="route('admin.restaurants.create')" 
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition"
            >
              + Add New Restaurant
            </Link>
          </div>

          <div class="overflow-x-auto">
            <table class="table-auto w-full text-left">
              <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-xs">
                  <th class="p-3">Restaurant Name</th>
                  <th class="p-3">City</th>
                  <th class="p-3">Owner</th>
                  <th class="p-3">Email</th>
                  <th class="p-3 text-right">Actions</th> 
                </tr>
              </thead>
              <tbody class="text-sm text-gray-600">
                <tr v-for="restaurant in restaurants" :key="restaurant.id" class="border-b hover:bg-gray-50">
                  <td class="p-3 font-medium text-gray-900">{{ restaurant.name }}</td>
                  <td class="p-3">
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">
                      {{ restaurant.city.name }}
                    </span>
                  </td>
                  <td class="p-3">{{ restaurant.owner.name }}</td>
                  <td class="p-3 text-blue-600 underline">
                    <a :href="'mailto:' + restaurant.owner.email">{{ restaurant.owner.email }}</a>
                  </td>
                  <td class="p-3 text-right">
                    <div class="flex justify-end items-center gap-4">
                      <Link 
                        v-if="can('restaurant.update')" 
                        :href="route('admin.restaurants.edit', restaurant.id)" 
                        class="text-indigo-600 hover:text-indigo-900 font-semibold"
                      >
                        Edit
                      </Link>

                      <button 
                        v-if="can('restaurant.delete')" 
                        @click="deleteRestaurant(restaurant.id)" 
                        class="text-red-600 hover:text-red-800 font-semibold"
                      >
                        Delete
                      </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="restaurants.length === 0">
                  <td colspan="5" class="p-6 text-center text-gray-500 italic">No restaurants found.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>