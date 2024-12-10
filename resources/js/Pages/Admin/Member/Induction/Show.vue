<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';

const { props } = usePage();
const { title, desc, memberInduction } = props;

const breadcrumbItems = [
  { label: 'Home', href: '/' },
  { label: 'Induksi Anggota', href: route('admin.member-inductions.index') },
  { label: 'Detail', href: '#' },
];

// Function to format date
const formatDate = (dateString) => {
  return dateString 
    ? new Date(dateString).toLocaleDateString('id-ID', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric' 
      }) 
    : '-';
};
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
                                        Nama Anggota
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ memberInduction.user.name }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Nama Trainer
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ memberInduction.trainer.name }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Kategori Alat
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ memberInduction.equipment_category.name }}
                                    </p>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Tanggal Induksi -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Tanggal Induksi
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ formatDate(memberInduction.induction_date) }}
                                    </p>
                                </div>

                                <!-- Status -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Status
                                    </h3>
                                    <span 
                                        :class="[
                                            'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full',
                                            memberInduction.is_completed 
                                                ? 'bg-green-100 text-green-800' 
                                                : 'bg-red-100 text-red-800'
                                        ]"
                                    >
                                        {{ memberInduction.is_completed ? 'Selesai' : 'Belum Selesai' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Catatan
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ memberInduction.notes || '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-8">
                            <ActionLink 
                                :href="route('admin.member-inductions.edit', memberInduction.slug)" 
                                label="Edit" 
                                color="warning"
                                class="px-4 py-2 text-sm"
                            />
                            <ActionLink 
                                :href="route('admin.member-inductions.index')" 
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