<script setup>

import { router, useForm, Head } from '@inertiajs/vue3';
import { debounce } from 'lodash-es';
import { ref, watch } from 'vue';
import { useToast } from 'vue-toastification';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import Pagination from '@/Components/Helpers/Pagination.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import { useRupiah } from '@/Composables/useRupiah';
import { useStatusTipeBayar } from '@/Composables/useStatusTipeBayar';
import { useStatusMetodeBayar } from '@/Composables/useStatusMetodeBayar';
import { useStatusBayar } from '@/Composables/useStatusBayar';

const props = defineProps({
    title: String,
    desc: String,
    payments: Object,
    filters: Object,
});

console.log(props.payments);


const toast = useToast();
const search = ref(props.filters.search || '');
const form = useForm({
    search: props.filters.search || '',
});

const debouncedSearch = debounce(() => {
    router.get(route('admin.payments.index'), { search: form.search }, {
        preserveScroll: true,
        preserveState: true,
    });
}, 300);

watch(search, (value) => {
    form.search = value;
    debouncedSearch();
});

const breadcrumbItems = [
    { label: 'Home', href: '/' },
    { label: 'Payment', href: '#' },
];

const { formatRupiah } = useRupiah();
const { formatStatusTipeBayar } = useStatusTipeBayar();
const { formatStatusMetodeBayar } = useStatusMetodeBayar();
const { formatStatusBayar } = useStatusBayar();

</script>

<template>

    <Head :title="title" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Breadcrumb :items="breadcrumbItems" />
                <div class="bg-white dark:bg-dark-default overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-200">
                        <div class="mb-4 flex items-center justify-between">
                            <TextInput v-model="search" type="text" placeholder="Search Payment..."
                                class="w-full sm:w-64" />
                            <ActionLink :href="route('admin.payments.create')" color="primary" label="Add" />
                        </div>

                        <div class="overflow-x-auto">
                            <table v-if="payments.data && payments.data.length"
                                class="min-w-full divide-y divide-gray-200 dark:divide-dark-background rounded-lg">
                                <thead class="bg-gray-50 dark:bg-dark-secondary">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            #</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Nama Anggota</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            No. Bayar</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Jumlah Bayar</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tanggal Bayar</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Metode Bayar</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tipe Pembayaran</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200 dark:bg-dark-background dark:divide-dark-background">
                                    <tr v-for="(payment, index) in payments.data" :key="payment.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 +
                                            (payments.current_page - 1)
                                            *
                                            payments.per_page }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ payment.user.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ payment.no_payment }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatRupiah(payment.amount) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ payment.created_at }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="formatStatusMetodeBayar(payment.payment_method).class">
                                                {{ formatStatusMetodeBayar(payment.payment_method).icon }} 
                                                {{ formatStatusMetodeBayar(payment.payment_method).text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="formatStatusTipeBayar(payment.payment_type).class">
                                                {{ formatStatusTipeBayar(payment.payment_type).icon }} 
                                                {{ formatStatusTipeBayar(payment.payment_type).text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="formatStatusBayar(payment.status).class">
                                                {{ formatStatusBayar(payment.status).icon }} 
                                                {{ formatStatusBayar(payment.status).text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                            <ActionLink :href="route('admin.payments.show', payment.slug)"
                                                color="primary" label="Detail" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p v-else class="text-gray-200 dark:text-gray-200">No Payment found</p>
                        </div>
                        <Pagination v-if="payments && payments.links" :links="payments.links" :limit="10"
                            class="mt-6" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>