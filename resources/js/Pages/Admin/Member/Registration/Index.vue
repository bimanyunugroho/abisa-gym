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

const props = defineProps({
    title: String,
    desc: String,
    memberRegistrations: Object,
    filters: Object,
});

const toast = useToast();
const search = ref(props.filters.search || '');
const form = useForm({
    search: props.filters.search || '',
});

const debouncedSearch = debounce(() => {
    router.get(route('admin.member-registrations.index'), { search: form.search }, {
        preserveScroll: true,
        preserveState: true,
    });
}, 300);

watch(search, (value) => {
    form.search = value;
    debouncedSearch();
});

function handleDeleteMemberRegistration(slug) {
    if (confirm('Apakah anda ingin menghapus data ini ?')) {
        router.delete(route('admin.member-registrations.destroy', slug), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => toast.success('Registrasi Anggota berhasil dihapus!')
        });
    }
}

function capitalize(value) {
    if (!value) return '';
    return value.charAt(0).toUpperCase() + value.slice(1);
}

const breadcrumbItems = [
    { label: 'Home', href: '/' },
    { label: 'Registrasi Anggota', href: '#' },
];

const { formatRupiah } = useRupiah();
const { formatTanggal, formatTanggalWaktu, formatWaktu } = useTanggal();
const { formatStatus, formatStatusOrientasi } = useStatus();

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
                            <TextInput v-model="search" type="text" placeholder="Search Registrasi..."
                                class="w-full sm:w-64" />
                            <ActionLink :href="route('admin.member-registrations.create')" color="primary" label="Add" />
                        </div>

                        <div class="overflow-x-auto">
                            <table v-if="memberRegistrations.data && memberRegistrations.data.length"
                                class="min-w-full divide-y divide-gray-200 dark:divide-dark-background rounded-lg">
                                <thead class="bg-gray-50 dark:bg-dark-secondary">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            #</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Nama User</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Plan Anggota</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tanggal Mulai</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tanggal Akhir</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Kunjungan Tersisa</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tgl. Orientasi</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Status Orientasi</th>
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
                                    <tr v-for="(memberRegistration, index) in memberRegistrations.data" :key="memberRegistration.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 +
                                            (memberRegistrations.current_page - 1)
                                            *
                                            memberRegistrations.per_page }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ memberRegistration.user.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ memberRegistration.membership_plan.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatTanggal(memberRegistration.start_date) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatTanggal(memberRegistration.end_date) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ memberRegistration.visits_left }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatTanggal(memberRegistration.orientation_date) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="formatStatusOrientasi(memberRegistration.orientation_completed).class">
                                                {{ formatStatusOrientasi(memberRegistration.orientation_completed).icon }} 
                                                {{ formatStatusOrientasi(memberRegistration.orientation_completed).text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ memberRegistration.status }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                            <ActionLink :href="route('admin.member-registrations.show', memberRegistration.slug)"
                                                color="primary" label="Detail" />
                                            <ActionLink :href="route('admin.member-registrations.edit', memberRegistration.slug)"
                                                color="warning" label="Edit" />
                                            <DeleteButton @click="() => handleDeleteMemberRegistration(memberRegistration.slug)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p v-else class="text-gray-200 dark:text-gray-200">No Plan Anggota found</p>
                        </div>
                        <Pagination v-if="memberRegistrations && memberRegistrations.links" :links="memberRegistrations.links" :limit="10"
                            class="mt-6" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Optional: Animasi hover */
.bg-gray-700 {
  transition: all 0.2s;
}

.bg-gray-700:hover {
  background-color: rgb(55 65 81 / 0.8);
  transform: translateY(-1px);
}
</style>