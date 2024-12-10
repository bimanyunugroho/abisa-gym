<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';

const breadcrumbItems = [
  { label: 'Home', href: '/' },
  { label: 'Dashboard', href: '#' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <Breadcrumb :items="breadcrumbItems" />
                <div
                    class="overflow-hidden bg-white shadow-sm rounded-lg dark:bg-dark-default"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-xl font-semibold mb-4">Dashboard</h2>
                        <p>You're logged in!</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
