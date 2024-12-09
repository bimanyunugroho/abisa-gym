<script setup>

import { router, useForm, Head } from '@inertiajs/vue3';
import { debounce } from 'lodash-es';
import { ref, watch } from 'vue';
import { useToast } from 'vue-toastification';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import Pagination from '@/Components/Helpers/Pagination.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import DeleteButton from '@/Components/Buttons/DeleteButton.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import { useRupiah } from '@/Composables/useRupiah';
import { useTanggal } from '@/Composables/useTanggal';
import { useStatus } from '@/Composables/useStatus';
import { useStatusVisit } from '@/Composables/useStatusVisit';

const props = defineProps({
    title: String,
    desc: String,
    gymVisits: Object,
    filters: Object,
});

console.log(props.gymVisits);


const toast = useToast();
const search = ref(props.filters.search || '');
const form = useForm({
    search: props.filters.search || '',
});

const debouncedSearch = debounce(() => {
    router.get(route('admin.gym-visits.index'), { search: form.search }, {
        preserveScroll: true,
        preserveState: true,
    });
}, 300);

watch(search, (value) => {
    form.search = value;
    debouncedSearch();
});

function handleDeleteGymVisit(slug) {
    if (confirm('Apakah anda ingin menghapus data ini ?')) {
        router.delete(route('admin.gym-visits.destroy', slug), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => toast.success('Kunjungan Gym berhasil dihapus!')
        });
    }
}

function capitalize(value) {
    if (!value) return '';
    return value.charAt(0).toUpperCase() + value.slice(1);
}

const breadcrumbItems = [
    { label: 'Home', href: '/' },
    { label: 'Kunjungan Gym', href: '#' },
];

const { formatRupiah } = useRupiah();
const { formatTanggal, formatTanggalWaktu, formatWaktu } = useTanggal();
const { formatStatus, formatStatusOrientasi } = useStatus();
const { formatStatusType } = useStatusVisit();

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
                            <TextInput v-model="search" type="text" placeholder="Search Kunjungan..."
                                class="w-full sm:w-64" />
                            <ActionLink :href="route('admin.gym-visits.create')" color="primary" label="Add" />
                        </div>

                        <div class="overflow-x-auto">
                            <table v-if="gymVisits.data && gymVisits.data.length"
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
                                            Member Registration</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Nama Tamu</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tanggal Check In</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tanggal Check Out</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tipe Kunjungan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Status Orientasi</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Total Dibayarkan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200 dark:bg-dark-background dark:divide-dark-background">
                                    <tr v-for="(gymVisit, index) in gymVisits.data" :key="gymVisit.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 +
                                            (gymVisits.current_page - 1)
                                            *
                                            gymVisits.per_page }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ gymVisit.user.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ gymVisit.member_registration.membership_plan.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ gymVisit.guest?.name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatTanggal(gymVisit.check_in_time) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatTanggal(gymVisit.check_out_time) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="formatStatusType(gymVisit.visit_type).class">
                                                {{ formatStatusType(gymVisit.visit_type).icon }} 
                                                {{ formatStatusType(gymVisit.visit_type).text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="formatStatusOrientasi(gymVisit.orientation_completed).class">
                                                {{ formatStatusOrientasi(gymVisit.orientation_completed).icon }} 
                                                {{ formatStatusOrientasi(gymVisit.orientation_completed).text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatRupiah(gymVisit.paid_amount) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                            <ActionLink :href="route('admin.gym-visits.show', gymVisit.slug)"
                                                color="primary" label="Detail" />
                                            <ActionLink :href="route('admin.gym-visits.edit', gymVisit.slug)"
                                                color="warning" label="Edit" />
                                            <DeleteButton @click="() => handleDeleteGymVisit(gymVisit.slug)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p v-else class="text-gray-200 dark:text-gray-200">No Kunjungan Gym found</p>
                        </div>
                        <Pagination v-if="gymVisits && gymVisits.links" :links="gymVisits.links" :limit="10"
                            class="mt-6" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>