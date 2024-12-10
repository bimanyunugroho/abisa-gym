<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import { useRupiah } from '@/Composables/useRupiah';
import { useTanggal } from '@/Composables/useTanggal';
import { useStatus } from '@/Composables/useStatus';
import { useStatusVisit } from '@/Composables/useStatusVisit';

const { props } = usePage();
const { title, gymVisit } = props;
const { formatRupiah } = useRupiah();
const { formatTanggal } = useTanggal();
const { formatStatus } = useStatus();
const { formatStatusType } = useStatusVisit();

console.log(gymVisit);


const breadcrumbItems = [
    { label: 'Home', href: '/' },
    { label: 'Kunjungan Gym', href: route('admin.gym-visits.index') },
    { label: 'Detail', href: '#' },
];
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Breadcrumb :items="breadcrumbItems" />
                <div class="bg-white dark:bg-dark-default shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Nama Anggota
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ gymVisit.user.name }} - {{ gymVisit.user.gym_number }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Plan Anggota
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ gymVisit.member_registration.membership_plan.name }}
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Tanggal Masuk - Keluar
                                    </h3>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-dark-accent" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ formatTanggal(gymVisit.check_in_time) }}
                                            </span>
                                        </div>
                                        <span class="text-gray-400 dark:text-gray-500">sampai</span>
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-dark-accent" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ formatTanggal(gymVisit.check_out_time) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Total Bayar
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ formatRupiah(gymVisit.paid_amount) }}
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        No. Telp | No. Emergency
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ gymVisit.user.phone_number }} | {{ gymVisit.user.emergency_contact }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Status
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        <span :class="formatStatusType(gymVisit.visit_type).class">
                                            {{ formatStatusType(gymVisit.visit_type).icon }} 
                                            {{ formatStatusType(gymVisit.visit_type).text }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Kondisi Kesehatan
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ gymVisit.user.health_conditions || '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Catatan
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ gymVisit.notes || '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-8">
                            <ActionLink 
                                :href="route('admin.gym-visits.edit', gymVisit.slug)" 
                                label="Edit" 
                                color="warning"
                                class="px-4 py-2 text-sm"
                            />
                            <ActionLink 
                                :href="route('admin.gym-visits.index')" 
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