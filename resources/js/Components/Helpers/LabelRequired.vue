<script setup>
defineProps({
    text: {
        type: String,
        required: true
    },
    htmlFor: {
        type: String,
        default: ''
    },
    required: {
        type: Boolean,
        default: true
    }
})
</script>

<template>
    <label 
        :for="htmlFor" 
        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
    >
        {{ text }}
        <span v-if="required" class="text-dark-accent ml-1">*</span>
    </label>
</template>