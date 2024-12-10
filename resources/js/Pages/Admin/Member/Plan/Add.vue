<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import CustomSelect from '@/Components/Inputs/CustomSelect.vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextArea from '@/Components/Inputs/TextArea.vue';
import SubmitButton from '@/Components/Buttons/SubmitButton.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import LabelRequired from '@/Components/Helpers/LabelRequired.vue';
import TextNumeric from '@/Components/Inputs/TextNumeric.vue';
import Checkbox from '@/Components/Inputs/Checkbox.vue';
import TextInputUppercase from '@/Components/Inputs/TextInputUppercase.vue';
import TimeRangePicker from '@/Components/Inputs/TimeRangePicker.vue';

const { props } = usePage();
const { title, desc, memberLevels, durationTypes, errors: pageErrors } = props;
const toast = useToast();
const form = useForm({
    'name': '',
    'member_level_id': '',
    'description': '',
    'price': '',
    'duration_days': '',
    'duration_type': '',
    'visit_limit': '',
    'access_all_branches': false,
    'available_times': [{
        start: '',
        end: ''
    }],
    'is_active': true,
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
    router.post(route('admin.membership-plans.store'), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Data plan berhasil disimpan!');
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
  { label: 'Plan Anggota', href: route('admin.membership-plans.index') },
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
                                    text="Nama Plan" 
                                    html-for="name"
                                    :required="true" 
                                />
                                <TextInputUppercase 
                                    id="name" 
                                    v-model="form.name" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    required
                                    autofocus 
                                    placeholder="Masukkan nama plan" 
                                />
                                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Level Anggota" 
                                    html-for="member_level_id"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.member_level_id"
                                    :options="memberLevels"
                                    :reduce="option => option.id"
                                    label="name"
                                    placeholder="Pilih level anggota"
                                />
                                <p v-if="form.errors.member_level_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.member_level_id }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Waktu Tersedia" 
                                    html-for="available_times"
                                    :required="true" 
                                />
                                <TimeRangePicker
                                    v-model="form.available_times"
                                    class="mt-1"
                                />
                                <div v-if="form.errors.available_times" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    <p v-if="typeof form.errors.available_times === 'string'">
                                        {{ form.errors.available_times }}
                                    </p>
                                    <template v-else>
                                        <p v-for="(error, index) in form.errors.available_times" :key="index">
                                            {{ error }}
                                        </p>
                                    </template>
                                </div>
                                <div v-if="form.errors['available_times.0.start']" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors['available_times.0.start'] }}
                                </div>
                                <div v-if="form.errors['available_times.0.end']" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors['available_times.0.end'] }}
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Biaya" 
                                    html-for="price"
                                    :required="true"
                                />
                                <TextNumeric 
                                    id="price"
                                    v-model="form.price"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.price" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.price }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Durasi" 
                                    html-for="duration_days"
                                    :required="true"
                                />
                                <TextNumeric 
                                    id="duration_days"
                                    v-model="form.duration_days"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.duration_days" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.duration_days }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Jenis Durasi" 
                                    html-for="duration_type"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.duration_type"
                                    :options="durationTypes"
                                    :reduce="option => option.value"
                                    label="label"
                                    placeholder="Pilih jenis durasi"
                                />
                                <p v-if="form.errors.duration_type" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.duration_type }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Batas Kunjungan" 
                                    html-for="visit_limit"
                                    :required="true"
                                />
                                <TextNumeric 
                                    id="visit_limit"
                                    v-model="form.visit_limit"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.visit_limit" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.visit_limit }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <Checkbox
                                        id="access_all_branches"
                                        name="access_all_branches"
                                        v-model="form.access_all_branches"
                                        :checked="form.access_all_branches"
                                    />
                                    <LabelRequired 
                                        text="Akses Semua Cabang" 
                                        html-for="access_all_branches"
                                        :required="true"
                                        class="ml-2"
                                    />
                                </label>
                                <p v-if="form.errors.access_all_branches" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.access_all_branches }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Catatan" 
                                    html-for="description"
                                    :required="true" 
                                />
                                <TextArea 
                                    id="description" 
                                    v-model="form.description" 
                                    class="mt-1 block w-full" 
                                    placeholder="Masukkan catatan" 
                                />
                                <p v-if="form.errors.description" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.description }}
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
                                    :href="route('admin.membership-plans.index')" 
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