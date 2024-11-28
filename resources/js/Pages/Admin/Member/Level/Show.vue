<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import { useRupiah } from '@/Composables/useRupiah';

const { props } = usePage();
const { title, desc, memberLevel } = props;


const breadcrumbItems = [
  { label: 'Home', href: '/' },
  { label: 'Level Anggota', href: route('admin.member-levels.index') },
  { label: 'Detail', href: '#' },
];

const { formatRupiah } = useRupiah();
</script>

<template>
    <Head :title="`Detail ${title}`" />

    <AuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Breadcrumb :items="breadcrumbItems" />
                
                <div class="bg-white dark:bg-dark-default shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <!-- Nama Anggota -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Nama Level
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ memberLevel.name }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Dapat latihan tanpa instruktur
                                    </h3>
                                    <p class="text-lg font-semibold">
                                        <span :class="memberLevel.can_train_without_trainer ? 'text-green-600' : 'text-red-600'">
                                            {{ memberLevel.can_train_without_trainer ? '✓' : '✗' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Membutuhkan Orientasi
                                    </h3>
                                    <p class="text-lg font-semibold">
                                        <span :class="memberLevel.needs_orientation ? 'text-green-600' : 'text-red-600'">
                                            {{ memberLevel.needs_orientation ? '✓' : '✗' }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Memiliki akses instruktur
                                    </h3>
                                    <p class="text-lg font-semibold">
                                        <span :class="memberLevel.has_trainer_access ? 'text-green-600' : 'text-red-600'">
                                            {{ memberLevel.has_trainer_access ? '✓' : '✗' }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Status -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Maksimal tamu
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ formatRupiah(parseFloat(memberLevel.max_guests)) }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Biaya tamu
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ formatRupiah(parseFloat(memberLevel.guest_fee)) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Catatan
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ memberLevel.description || '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-8">
                            <ActionLink 
                                :href="route('admin.member-levels.edit', memberLevel.slug)" 
                                label="Edit" 
                                color="warning"
                                class="px-4 py-2 text-sm"
                            />
                            <ActionLink 
                                :href="route('admin.member-levels.index')" 
                                label="Kembali" 
                                color="secondary" 
                                class="px-4 py-2 text-sm"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>