<script setup>
defineProps({
  items: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <nav class="mb-2" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-0 text-sm font-medium">
      <li v-for="(item, index) in items" :key="index" class="flex items-center">
        <template v-if="index !== items.length - 1">
          <a
            :href="item.href"
            class="text-gray-500 hover:text-primary-600 dark:text-dark-default dark:hover:text-primary-500 transition-colors duration-200"
          >
            {{ item.label }}
          </a>
          <svg
            class="w-5 h-5 text-gray-400 mx-1"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd"
            />
          </svg>
        </template>
        <span
          v-else
          class="text-gray-800 dark:text-gray-200 font-semibold"
          aria-current="page"
        >
          {{ item.label }}
        </span>
      </li>
    </ol>
  </nav>
</template>
