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

const props = defineProps({
    title: String,
    desc: String,
    memberInductions: Object,
    filters: Object,
});

console.log(props.memberInductions);


const toast = useToast();
const search = ref(props.filters.search || '');
const form = useForm({
    search: props.filters.search || '',
});

const debouncedSearch = debounce(() => {
    router.get(route('admin.member-inductions.index'), { search: form.search }, {
        preserveScroll: true,
        preserveState: true,
    });
}, 300);

watch(search, (value) => {
    form.search = value;
    debouncedSearch();
});

function handleDeleteMemberInduction(slug) {
    if (confirm('Apakah anda ingin menghapus data ini ?')) {
        router.delete(route('admin.member-inductions.destroy', slug), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => toast.success('Induksi Anggota berhasil dihapus!')
        });
    }
}

function capitalize(value) {
    if (!value) return '';
    return value.charAt(0).toUpperCase() + value.slice(1);
}

const breadcrumbItems = [
    { label: 'Home', href: '/' },
    { label: 'Induksi Anggota', href: '#' },
];

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
                            <TextInput v-model="search" type="text" placeholder="Search Induksi..."
                                class="w-full sm:w-64" />
                            <ActionLink :href="route('admin.member-inductions.create')" color="primary" label="Add" />
                        </div>

                        <div class="overflow-x-auto">
                            <table v-if="memberInductions.data && memberInductions.data.length"
                                class="min-w-full divide-y divide-gray-200 dark:divide-dark-background rounded-lg">
                                <thead class="bg-gray-50 dark:bg-dark-secondary">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            #</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Anggota</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Trainer</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Kategori</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Tanggal Induksi</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Status Selesai</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-100 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200 dark:bg-dark-background dark:divide-dark-background">
                                    <tr v-for="(memberInduction, index) in memberInductions.data" :key="memberInduction.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 +
                                            (memberInductions.current_page - 1)
                                            *
                                            memberInductions.per_page }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ memberInduction.user.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ memberInduction.trainer.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ memberInduction.equipment_category.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ memberInduction.induction_date
                                            }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span v-if="memberInduction.is_completed"
                                                class="text-green-600 dark:text-green-400">✓</span>
                                            <span v-else class="text-red-600 dark:text-red-400">✗</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                            <ActionLink :href="route('admin.member-inductions.show', memberInduction.slug)"
                                                color="primary" label="Detail" />
                                            <ActionLink :href="route('admin.member-inductions.edit', memberInduction.slug)"
                                                color="warning" label="Edit" />
                                            <DeleteButton @click="() => handleDeleteMemberInduction(memberInduction.slug)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p v-else class="text-gray-200 dark:text-gray-200">No Induksi Anggota found</p>
                        </div>
                        <Pagination v-if="memberInductions && memberInductions.links" :links="memberInductions.links" :limit="10"
                            class="mt-6" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>