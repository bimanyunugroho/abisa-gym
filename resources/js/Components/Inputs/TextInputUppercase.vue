<script setup>
import { ref, onMounted, watch } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

watch(model, (newValue) => {
    model.value = newValue.toUpperCase();
});

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>


<template>
    <input
        class="border-gray-300 dark:border-gray-700 dark:bg-dark-background dark:text-gray-300 focus:border-dark-muted dark:focus:border-dark-muted focus:ring-dark-border dark:focus:ring-dark-border rounded-md shadow-sm"
        v-model="model"
        ref="input"
        @input="model = $event.target.value.toUpperCase()"
    />
</template>
