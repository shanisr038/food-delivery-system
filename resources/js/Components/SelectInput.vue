<script setup>
defineProps(['modelValue', 'options', 'placeholder']);
defineEmits(['update:modelValue']);
</script>
<template>
    <select :value="modelValue" @change="$emit('update:modelValue', $event.target.value)" 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
        <option value="">{{ placeholder || 'Select an option' }}</option>
        <option v-for="option in options" :key="option.id" :value="option.id">
            {{ option.name }}
        </option>
    </select>
</template>