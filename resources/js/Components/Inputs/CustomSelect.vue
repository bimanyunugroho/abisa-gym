<template>
    <VueSelect
        v-bind="$attrs"
        :class="[
            'mt-1 block w-full rounded-md border-gray-300',
            'focus:border-orange-500 focus:ring-orange-500',
            'dark:border-dark-background dark:bg-dark-background',
            '[&_.vs__dropdown-toggle]:!border-0 [&_.vs__dropdown-toggle]:!border-gray-300 dark:[&_.vs__dropdown-toggle]:!border-dark-background',
            '[&_.vs__dropdown-toggle]:!rounded-md [&_.vs__dropdown-toggle]:!px-3 [&_.vs__dropdown-toggle]:!py-2',
            '[&_.vs__selected]:!m-0 [&_.vs__selected]:!p-0 [&_.vs__selected]:!text-dark-backbg-dark-background dark:[&_.vs__selected]:!text-gray-400',
            '[&_.vs__search]:!m-0 [&_.vs__search]:!p-0 [&_.vs__search]:!text-dark-backbg-dark-background dark:[&_.vs__search]:!text-gray-400',
            '[&_.vs__search]:[&::placeholder]:text-gray-500 dark:[&_.vs__search]:[&::placeholder]:text-gray-400',
            '[&_.vs__dropdown-menu]:!rounded-md [&_.vs__dropdown-menu]:!mt-1 [&_.vs__dropdown-menu]:!bg-white dark:[&_.vs__dropdown-menu]:!bg-gray-800',
            '[&_.vs__dropdown-menu]:!border [&_.vs__dropdown-menu]:!border-gray-300 dark:[&_.vs__dropdown-menu]:!border-dark-background',
            '[&_.vs__dropdown-menu]:!shadow-lg',
            '[&_.vs__dropdown-option]:!px-3 [&_.vs__dropdown-option]:!py-2 [&_.vs__dropdown-option]:!text-dark-backbg-dark-background dark:[&_.vs__dropdown-option]:!text-gray-400',
            '[&_.vs__dropdown-option--highlight]:!bg-orange-500 [&_.vs__dropdown-option--highlight]:!text-white',
            '[&_.vs__actions]:!p-0',
            '[&_.vs__clear]:!fill-gray-500 dark:[&_.vs__clear]:!fill-gray-400',
            '[&_.vs__open-indicator]:!fill-gray-500 dark:[&_.vs__open-indicator]:!fill-gray-400'
        ]"
    >
        <template v-for="(_, slot) in $slots" :key="slot" #[slot]="scope">
            <slot :name="slot" v-bind="scope" />
        </template>
    </VueSelect>
</template>

<script setup>
import VueSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
</script>

<style>
.v-select {
    position: relative;
}

.vs__dropdown-toggle {
    display: flex;
    height: 38px;
    align-items: center;
}

.vs__selected-options {
    display: flex;
    flex-basis: 100%;
    flex-grow: 1;
    flex-wrap: wrap;
    padding: 0 2px;
    position: relative;
}

.vs__actions {
    display: flex;
    align-items: center;
    padding-right: 4px;
}

.vs__clear {
    margin-right: 4px;
}

.vs__search {
    background: none;
    border: none;
    flex-grow: 1;
    width: 0;
}

.vs__search:focus {
    outline: none;
}

.vs__dropdown-menu {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    width: 100%;
    overflow-y: auto;
    box-sizing: border-box;
}

.vs__no-options {
    padding: 8px 12px;
    text-align: center;
    color: #6b7280;
}

.vs--single .vs__selected {
    display: flex;
    align-items: center;
    color: white;
}

.vs__selected {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.vs__dropdown-menu {
  background-color: #252525 !important;
  border-color: #374151 !important;
}

.vs__dropdown-option {
  color: white !important;
}

.vs__dropdown-option:hover {
  background-color: #FF6347 !important;
  color: white !important;
}

.vs__dropdown-option--highlight {
  background-color: #4338CA !important;
  color: white !important;
}

.vs__no-options {
  color: #9CA3AF !important;
}
</style>