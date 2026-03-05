<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'

const props = defineProps({
  current_orders: Array,
  past_orders: Array,
  order_status: Object
})

const form = useForm({
  status: null
})

const updateStatus = (order, status) => {
  form.status = status
  form.put(route('staff.orders.update', order.id), {
    preserveScroll: true
  })
}
</script>

<template>
  <Head title="Restaurant Orders" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Restaurant Orders</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 overflow-x-auto">
            <header>
              <h2 class="text-lg font-medium text-gray-900">Current Orders</h2>
            </header>

            <table class="w-full mt-6 text-left border-collapse">
              <thead>
                <tr class="border-b">
                  <th class="py-2">Order ID</th>
                  <th class="py-2">Items</th>
                  <th class="py-2">Customer</th>
                  <th class="py-2">Total</th>
                  <th class="py-2">Status</th>
                  <th class="py-2 text-right">Actions</th>
                </tr>
              </thead>
              <tbody class="align-top">
                <tr v-for="order in current_orders" :key="order.id" class="border-b">
                  <td class="py-4">{{ order.id }}</td>
                  <td class="py-4">
                    <div v-for="product in order.products" :key="product.id" class="text-sm">
                      {{ product?.quantity ?? 1 }}x {{ product.name }}
                    </div>
                  </td>
                  <td class="py-4">{{ order.customer?.name ?? 'Guest' }}</td>
                  <td class="py-4 whitespace-nowrap">{{ (order.total / 100).toFixed(2) }} &euro;</td>
                  <td class="py-4">
                    <span class="px-2 py-1 rounded text-xs font-bold uppercase" 
                      :class="order.status === order_status.PENDING ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800'">
                      {{ order.status }}
                    </span>
                  </td>
                  <td class="py-4">
                    <div class="flex gap-2 justify-end">
                      <SecondaryButton 
                        v-if="order.status === order_status.PENDING" 
                        @click="updateStatus(order, order_status.PREPARING)"
                      >
                        Prepare
                      </SecondaryButton>
                      <PrimaryButton 
                        v-if="order.status === order_status.PREPARING" 
                        @click="updateStatus(order, order_status.READY)"
                      >
                        Ready
                      </PrimaryButton>
                      <DangerButton 
                        v-if="order.status !== order_status.CANCELLED"
                        @click="updateStatus(order, order_status.CANCELLED)"
                      >
                        Cancel
                      </DangerButton>
                    </div>
                  </td>
                </tr>
                <tr v-if="current_orders.length === 0">
                    <td colspan="6" class="py-4 text-center text-gray-500">No active orders.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 overflow-x-auto">
            <header>
              <h2 class="text-lg font-medium text-gray-900">Past Orders</h2>
            </header>

            <table class="w-full mt-6 text-left border-collapse">
              <thead>
                <tr class="border-b">
                  <th class="py-2">Order ID</th>
                  <th class="py-2">Customer</th>
                  <th class="py-2">Total</th>
                  <th class="py-2 text-right">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in past_orders" :key="order.id" class="border-b">
                  <td class="py-4">{{ order.id }}</td>
                  <td class="py-4">{{ order.customer?.name ?? 'Guest' }}</td>
                  <td class="py-4">{{ (order.total / 100).toFixed(2) }} &euro;</td>
                  <td class="py-2 text-right">
                    <span class="px-2 py-1 rounded text-xs font-bold uppercase"
                      :class="order.status === order_status.READY ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                      {{ order.status }}
                    </span>
                  </td>
                </tr>
                <tr v-if="past_orders.length === 0">
                    <td colspan="4" class="py-4 text-center text-gray-500">No past orders found.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>