<script setup>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: [Date, String],
        default: null
    },
    placeholder: {
        type: String,
        default: 'Pilih Tanggal'
    }
});

const emit = defineEmits(['update:modelValue']);
const selectedDate = ref(props.modelValue ? new Date(props.modelValue) : null);

// Watch perubahan dari parent
watch(() => props.modelValue, (newVal) => {
    selectedDate.value = newVal ? new Date(newVal) : null;
});

const updateValue = (date) => {
    if (!date) {
        selectedDate.value = null;
        emit('update:modelValue', null);
        return;
    }
    
    selectedDate.value = date;
    const d = new Date(date);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    const formattedDate = `${year}-${month}-${day}`;
    
    emit('update:modelValue', formattedDate);
};

const formatDisplayDate = (date) => {
    if (!date) return '';
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}-${month}-${year}`;
};
</script>

<template>
    <div>
        <VueDatePicker
            v-model="selectedDate"
            @update:model-value="updateValue"
            :format="'dd-MM-yyyy'"
            :placeholder="placeholder"
            :enable-time-picker="false"
            locale="id"
            auto-apply
            text-input
            class="w-full"
            :clearable="false"
        >
            <template #dp-input="{ inputValue, togglePopover }">
                <input
                    :value="formatDisplayDate(selectedDate)"
                    @click="togglePopover"
                    readonly
                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-dark-background dark:text-gray-300 focus:border-dark-muted dark:focus:border-dark-muted focus:ring-dark-border dark:focus:ring-dark-border shadow-sm"
                    :placeholder="placeholder"
                />
            </template>
        </VueDatePicker>
    </div>
</template>

<style>
.dp-custom-input {
    width: 100%;
    padding: 0.5rem;
    border-radius: 0.375rem;
    border: 1px solid #d1d5db;
    background-color: #fff;
}

.dark .dp-custom-input {
    background-color: #111827;
    border-color: #374151;
    color: #e5e7eb;
}
</style> 