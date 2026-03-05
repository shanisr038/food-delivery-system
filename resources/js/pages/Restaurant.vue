<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, usePage, useForm } from '@inertiajs/vue3'

const page = usePage()
const form = useForm({})

const props = defineProps({
  restaurant: Object
})

const addProduct = (product) => {
  form.post(route('customer.cart.add', product.id), {
    preserveScroll: true,
    onError: () => {
      // Access the restaurant name from the global cart prop shared in HandleInertiaRequests
      const oldRestaurant = page.props.cart.restaurant_name;
      
      if (confirm(`This will remove your existing order from ${oldRestaurant}. Do you want to start a new order at ${props.restaurant.name}?`)) {
        form.delete(route('customer.cart.destroy'), {
          onSuccess: () => addProduct(product)
        })
      }
    }
  })
}
</script>

<template>
  <Head :title="restaurant.name" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ restaurant.name }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 flex flex-col gap-8">
            
            <div class="border-b pb-4">
                <p class="text-gray-600">{{ restaurant.city.name }} • {{ restaurant.address }}</p>
            </div>

            <div
              v-for="category in restaurant.categories"
              :key="category.id"
              class="flex flex-col gap-4"
            >
              <div class="text-2xl font-bold border-b pb-2">{{ category.name }}</div>
              
              <div class="flex flex-col gap-6">
                <div
                  v-for="product in category.products"
                  :key="product.id"
                  class="flex justify-between items-center pb-6 border-b border-gray-100 gap-4"
                >
                  <div class="flex flex-col gap-1">
                    <div class="font-bold text-lg">{{ product.name }}</div>
                    <div class="text-gray-500">${{ (product.price / 100).toFixed(2) }}</div>
                  </div>

                  <div class="flex items-center">
                    <button
                      v-if="can('cart.add') || !$page.props.auth.user"
                      @click="addProduct(product)"
                      class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150"
                      type="button"
                    >
                      Add to Cart
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="restaurant.categories.length === 0" class="text-center text-gray-500">
                This restaurant hasn't added any menu items yet.
            </div>

          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>