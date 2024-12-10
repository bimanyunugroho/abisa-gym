<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import { useRupiah } from '@/Composables/useRupiah';
import { useStatusTipeBayar } from '@/Composables/useStatusTipeBayar';
import { useStatusMetodeBayar } from '@/Composables/useStatusMetodeBayar';
import { useStatusBayar } from '@/Composables/useStatusBayar';

const { props } = usePage();
const { title, payment } = props;
const { formatRupiah } = useRupiah();
const { formatStatusTipeBayar } = useStatusTipeBayar();
const { formatStatusMetodeBayar } = useStatusMetodeBayar();
const { formatStatusBayar } = useStatusBayar();

const breadcrumbItems = [
    { label: 'Home', href: '/' },
    { label: 'Pembayaran', href: route('admin.payments.index') },
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
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Detail Pembayaran</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Informasi lengkap transaksi pembayaran</p>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid md:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        No. Payment
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ payment.no_payment }}
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Nama Anggota
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ payment.user.name }} - {{ payment.user.gym_number }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Total Bayar
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ formatRupiah(payment.amount) }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Tanggal Bayar
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ payment.created_at }}
                                    </p>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Metode Bayar
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        <span :class="formatStatusMetodeBayar(payment.payment_method).class">
                                            {{ formatStatusMetodeBayar(payment.payment_method).icon }} 
                                            {{ formatStatusMetodeBayar(payment.payment_method).text }}
                                        </span>
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Tipe Pembayaran
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        <span :class="formatStatusTipeBayar(payment.payment_type).class">
                                            {{ formatStatusTipeBayar(payment.payment_type).icon }} 
                                            {{ formatStatusTipeBayar(payment.payment_type).text }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-dark-background p-3 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Status
                                    </h3>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        <span :class="formatStatusBayar(payment.status).class">
                                            {{ formatStatusBayar(payment.status).icon }} 
                                            {{ formatStatusBayar(payment.status).text }}
                                        </span>
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
                                    {{ payment.notes || '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 mt-8">
                            <ActionLink 
                                :href="route('admin.payments.index')" 
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