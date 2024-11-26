<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-gray-300 dark:border-gray-700 dark:bg-dark-background dark:text-gray-200 focus:border-dark-muted dark:focus:border-dark-muted focus:ring-dark-border dark:focus:ring-dark-border rounded-md shadow-sm"
        v-model="model"
        ref="input"
    />
</template>
