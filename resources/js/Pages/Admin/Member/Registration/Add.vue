<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import CustomSelect from '@/Components/Inputs/CustomSelect.vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SubmitButton from '@/Components/Buttons/SubmitButton.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import LabelRequired from '@/Components/Helpers/LabelRequired.vue';
import TextNumeric from '@/Components/Inputs/TextNumeric.vue';
import CustomDatePicker from '@/Components/Inputs/CustomDatePicker.vue';

const { props } = usePage();
const { title, desc, users, membershipPlans, statuses, errors: pageErrors } = props;
const toast = useToast();
const form = useForm({
    'user_id': '',
    'membership_plan_id': '',
    'start_date': '',
    'end_date': '',
    'visits_left': '',
    'status': '',
    'orientation_date': '',
    'orientation_completed': false,
});

// Menyalin semua error dari pageErrors ke form.errors
Object.keys(pageErrors).forEach(key => {
    if (pageErrors[key]) {
        form.errors[key] = pageErrors[key];
    }
});

const isProcessing = ref(false);

function handleSubmit() {
    isProcessing.value = true;
    router.post(route('admin.member-registrations.store'), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Data registrasi berhasil disimpan!');
            form.reset();
            isProcessing.value = false;
        },
        onError: (errors) => {
            toast.error('Terjadi kesalahan, silakan cek kembali form anda');
            isProcessing.value = false;
        }
    });
}

const breadcrumbItems = [
  { label: 'Home', href: '/' },
  { label: 'Registrasi Anggota', href: route('admin.member-registrations.index') },
  { label: 'Tambah', href: '#' },
];
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Breadcrumb :items="breadcrumbItems" />
                <div class="bg-white dark:bg-dark-default overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="handleSubmit">
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Anggota" 
                                    html-for="user_id"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.user_id"
                                    :options="users"
                                    :reduce="option => option.id"
                                    label="name"
                                    placeholder="Pilih anggota"
                                />
                                <p v-if="form.errors.user_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.user_id }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Plan Anggota" 
                                    html-for="membership_plan_id"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.membership_plan_id"
                                    :options="membershipPlans"
                                    :reduce="option => option.id"
                                    label="name"
                                    placeholder="Pilih plan anggota"
                                />
                                <p v-if="form.errors.membership_plan_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.membership_plan_id }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Mulai" 
                                    html-for="start_date"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.start_date"
                                    placeholder="Pilih tanggal mulai"
                                />
                                <p v-if="form.errors.start_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.start_date }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Selesai" 
                                    html-for="end_date"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.end_date"
                                    placeholder="Pilih tanggal selesai"
                                />
                                <p v-if="form.errors.end_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.end_date }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Batas Kunjungan" 
                                    html-for="visits_left"
                                    :required="true"
                                />
                                <TextNumeric 
                                    id="visits_left"
                                    v-model="form.visits_left"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.visits_left" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.visits_left }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Orientasi" 
                                    html-for="orientation_date"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.orientation_date"
                                    placeholder="Pilih tanggal orientasi"
                                />
                                <p v-if="form.errors.orientation_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.orientation_date }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Status" 
                                    html-for="status"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.status"
                                    :options="statuses"
                                    :reduce="option => option.value"
                                    label="label"
                                    placeholder="Pilih status"
                                />
                                <p v-if="form.errors.status" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.status }}
                                </p>
                            </div>

                            <div class="flex items-center justify-end mt-4 space-x-2">
                                <SubmitButton 
                                    :processing="isProcessing" 
                                    :disabled="!form.isDirty" 
                                    @click="handleSubmit"
                                    label="Simpan" 
                                />
                                <ActionLink 
                                    :href="route('admin.member-registrations.index')" 
                                    label="Batal" 
                                    color="secondary" 
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>