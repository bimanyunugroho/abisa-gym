<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';

const { props } = usePage();
const { title, desc, equipment } = props;

const breadcrumbItems = [
  { label: 'Home', href: '/' },
  { label: 'Master Alat', href: route('admin.equipments.index') },
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
                                <!-- Nama Alat -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Nama Alat
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ equipment.name }}
                                    </p>
                                </div>

                                <!-- Model -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Model
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ equipment.model }}
                                    </p>
                                </div>

                                <!-- Brand -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Brand
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ equipment.brand }}
                                    </p>
                                </div>

                                <!-- Kategori -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Kategori
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ equipment.category?.name || '-' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Tanggal Pembelian -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Tanggal Pembelian
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ formatDate(equipment.purchase_date) }}
                                    </p>
                                </div>

                                <!-- Tanggal Pemeliharaan Terakhir -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Tanggal Pemeliharaan Terakhir
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ formatDate(equipment.last_maintenance_date) }}
                                    </p>
                                </div>

                                <!-- Kondisi -->
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Kondisi
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ equipment.condition }}
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
                                            equipment.is_active 
                                                ? 'bg-green-100 text-green-800' 
                                                : 'bg-red-100 text-red-800'
                                        ]"
                                    >
                                        {{ equipment.is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details (Full Width) -->
                        <div class="mt-6 space-y-4">
                            <!-- Instruksi Penggunaan -->
                            <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Instruksi Penggunaan
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ equipment.usage_instructions || '-' }}
                                </p>
                            </div>

                            <!-- Deskripsi -->
                            <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Deskripsi
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ equipment.description || '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-8">
                            <ActionLink 
                                :href="route('admin.equipments.edit', equipment.slug)" 
                                label="Edit" 
                                color="warning"
                                class="px-4 py-2 text-sm"
                            />
                            <ActionLink 
                                :href="route('admin.equipments.index')" 
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