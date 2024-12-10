<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import { useGender } from '@/Composables/useGender';
import { useTanggal } from '@/Composables/useTanggal';
import { useAge } from '@/Composables/useAge';

const { props } = usePage();
const { title, member } = props;

console.log(member);


const { formatGender } = useGender();
const { formatTanggal, formatTanggalWaktu, formatWaktu } = useTanggal();
const { calculateAge } = useAge();

const breadcrumbItems = [
    { label: 'Home', href: '/' },
    { label: 'Anggota', href: route('admin.members.index') },
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
                                        Nama
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ member.name }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Email
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ member.email }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        No. HP
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ member.phone_number }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Role
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ member.role }}
                                    </p>
                                </div>


                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        No. GYM
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ member.gym_number ?? '-' }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Gender
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        <span :class="formatGender(member.gender).class">
                                            {{ formatGender(member.gender).text }}
                                        </span>
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Tanggal Lahir
                                    </h3>
                                    <div class="flex items-center gap-2">
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ formatTanggal(member.birth_date) }}
                                        </p>
                                        <span class="text-sm text-gray-500 dark:text-dark-default font-bold">
                                            ({{ calculateAge(member.birth_date) }})
                                        </span>
                                    </div>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Kontak Darurat
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ member.emergency_contact }}
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
                                    {{ member.health_conditions || '-' }}
                                </p>
                            </div>

                            <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                    Alamat
                                </h3>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ member.address || '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-8">
                            <ActionLink 
                                :href="route('admin.members.edit', member.slug)" 
                                label="Edit" 
                                color="warning"
                                class="px-4 py-2 text-sm"
                            />
                            <ActionLink 
                                :href="route('admin.members.index')" 
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