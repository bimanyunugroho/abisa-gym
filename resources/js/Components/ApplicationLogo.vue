<script setup>
import { usePage } from '@inertiajs/vue3';

const appName = usePage().props.app.name;
</script>

<template>
    <div class="flex items-center gap-1">
        <div class="p-1 rounded-full bg-dark-accent bg-opacity-10">
            <svg 
                class="w-6 h-6 text-dark-accent" 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M5.45 5.11L2 12v6a2 2 0 002 2h16a2 2 0 002-2v-6l-3.45-6.89A2 2 0 0016.76 4H7.24a2 2 0 00-1.79 1.11z"
                />
                <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M12 8v4m0 4h.01"
                />
            </svg>
        </div>
        <span class="text-xl font-bold text-dark-accent">{{ appName }}</span>
    </div>
</template>
