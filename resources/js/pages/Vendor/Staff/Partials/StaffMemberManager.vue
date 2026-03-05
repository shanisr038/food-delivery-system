<script setup>
import { router } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    members: Array
});

const removeMember = (member) => {
    if (confirm(`Are you sure you want to remove ${member.name}?`)) {
        router.delete(route('vendor.staff-members.destroy', member.id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Team Members</h2>
            <p class="mt-1 text-sm text-gray-600">Active staff members for your restaurant.</p>
        </header>

        <div class="mt-6 space-y-4">
            <div v-for="member in members" :key="member.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <div class="font-semibold text-gray-900">{{ member.name }}</div>
                    <div class="text-sm text-gray-500">{{ member.email }}</div>
                </div>
                <DangerButton 
                    v-if="can('user.delete')" 
                    @click="removeMember(member)"
                >
                    Remove
                </DangerButton>
            </div>
            
            <div v-if="members && members.length === 0" class="text-center py-4 text-gray-500 italic">
                No staff members found.
            </div>
        </div>
    </section>
</template>