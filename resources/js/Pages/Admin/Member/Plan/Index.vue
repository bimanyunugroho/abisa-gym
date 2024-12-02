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

const props = defineProps({
    title: String,
    desc: String,
    membershipPlans: Object,
    filters: Object,
});

const toast = useToast();
const search = ref(props.filters.search || '');
const form = useForm({
    search: props.filters.search || '',
});

const debouncedSearch = debounce(() => {
    router.get(route('admin.membership-plans.index'), { search: form.search }, {
        preserveScroll: true,
        preserveState: true,
    });
}, 300);

watch(search, (value) => {
    form.search = value;
    debouncedSearch();
});

function handleDeleteMemberPlan(slug) {
    if (confirm('Apakah anda ingin menghapus data ini ?')) {
        router.delete(route('admin.membership-plans.destroy', slug), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => toast.success('Plan Anggota berhasil dihapus!')
        });
    }
}

function capitalize(value) {
    if (!value) return '';
    return value.charAt(0).toUpperCase() + value.slice(1);
}

const breadcrumbItems = [
    { label: 'Home', href: '/' },
    { label: 'Plan Anggota', href: '#' },
];

const { formatRupiah } = useRupiah();

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
                            <TextInput v-model="search" type="text" placeholder="Search Plan..."
                                class="w-full sm:w-64" />
                            <ActionLink :href="route('admin.membership-plans.create')" color="primary" label="Add" />
                        </div>

                        <div class="overflow-x-auto">
                            <table v-if="membershipPlans.data && membershipPlans.data.length"
                                class="min-w-full divide-y divide-gray-200 dark:divide-dark-background rounded-lg">
                                <thead class="bg-gray-50 dark:bg-dark-secondary">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            #</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Nama Plan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Level Anggota</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Harga</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Durasi Hari</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tipe Durasi</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Batas Kunjungan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Akses Rute</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Akses Jam</th>
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
                                    <tr v-for="(membershipPlan, index) in membershipPlans.data" :key="membershipPlan.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 +
                                            (membershipPlans.current_page - 1)
                                            *
                                            membershipPlans.per_page }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ membershipPlan.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ membershipPlan.member_level.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatRupiah(membershipPlan.price) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatRupiah(membershipPlan.duration_days) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ membershipPlan.duration_type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ formatRupiah(membershipPlan.visit_limit) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ membershipPlan.access_all_branches }}</td>
                                        <td class="px-3 py-2 text-sm">
                                            <div class="space-y-1">
                                                <div 
                                                    v-for="(time, index) in membershipPlan.available_times" 
                                                    :key="index"
                                                    class="flex items-center gap-2 bg-dark-secondary px-3 py-1.5 rounded-md text-white"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-dark-accent" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="font-medium">{{ time.start }}</span>
                                                    <span class="text-dark-accent">-</span>
                                                    <span class="font-medium">{{ time.end }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span v-if="membershipPlan.is_active"
                                                class="text-green-600 dark:text-green-400">✓</span>
                                            <span v-else class="text-red-600 dark:text-red-400">✗</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                            <ActionLink :href="route('admin.membership-plans.show', membershipPlan.slug)"
                                                color="primary" label="Detail" />
                                            <ActionLink :href="route('admin.membership-plans.edit', membershipPlan.slug)"
                                                color="warning" label="Edit" />
                                            <DeleteButton @click="() => handleDeleteMemberPlan(membershipPlan.slug)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p v-else class="text-gray-200 dark:text-gray-200">No Plan Anggota found</p>
                        </div>
                        <Pagination v-if="membershipPlans && membershipPlans.links" :links="membershipPlans.links" :limit="10"
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