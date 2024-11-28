<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import CustomSelect from '@/Components/Inputs/CustomSelect.vue';
import CustomDatePicker from '@/Components/Inputs/CustomDatePicker.vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextArea from '@/Components/Inputs/TextArea.vue';
import SubmitButton from '@/Components/Buttons/SubmitButton.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import LabelRequired from '@/Components/Helpers/LabelRequired.vue';
import Checkbox from '@/Components/Inputs/Checkbox.vue';

const { props } = usePage();
const { title, desc, users, trainers, equipmentCategories, memberInduction, errors: pageErrors } = props;
const toast = useToast();
const form = useForm({
    'user_id': memberInduction.user_id,
    'trainer_id': memberInduction.trainer_id,
    'equipment_category_id': memberInduction.equipment_category_id,
    'induction_date': memberInduction.induction_date,
    'slug': memberInduction.slug,
    'notes': memberInduction.notes,
    'is_completed': memberInduction.is_completed,
});

console.log(memberInduction);


// Menyalin semua error dari pageErrors ke form.errors
Object.keys(pageErrors).forEach(key => {
    if (pageErrors[key]) {
        form.errors[key] = pageErrors[key];
    }
});

const isProcessing = ref(false);

function handleSubmit() {
    isProcessing.value = true;
    router.put(route('admin.member-inductions.update', memberInduction.slug), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Data induksi berhasil diubah!');
            form.reset();
            isProcessing.value = false;
        },
        onError: (errors) => {
            form.errors = errors;
            toast.error('Ooppss...');
            isProcessing.value = false;
        }
    });
}

const breadcrumbItems = [
  { label: 'Home', href: '/' },
  { label: 'Induksi Anggota', href: route('admin.member-inductions.index') },
  { label: 'Ubah', href: '#' },
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
                                    text="Trainer" 
                                    html-for="trainer_id"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.trainer_id"
                                    :options="trainers"
                                    :reduce="option => option.id"
                                    label="name"
                                    placeholder="Pilih trainer"
                                />
                                <p v-if="form.errors.trainer_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.trainer_id }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Kategori" 
                                    html-for="equipment_category_id"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.equipment_category_id"
                                    :options="equipmentCategories"
                                    :reduce="option => option.id"
                                    label="name"
                                    placeholder="Pilih kategori"
                                />
                                <p v-if="form.errors.equipment_category_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.equipment_category_id }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Induksi" 
                                    html-for="induction_date"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.induction_date"
                                    placeholder="Pilih tanggal induksi"
                                />
                                <p v-if="form.errors.induction_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.induction_date }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Catatan" 
                                    html-for="notes"
                                    :required="true" 
                                />
                                <TextArea 
                                    id="notes" 
                                    v-model="form.notes" 
                                    class="mt-1 block w-full" 
                                    placeholder="Masukkan catatan" 
                                />
                                <p v-if="form.errors.notes" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.notes }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <Checkbox
                                        id="is_completed"
                                        name="is_completed"
                                        v-model="form.is_completed"
                                        :checked="form.is_completed"
                                    />
                                    <LabelRequired 
                                        text="Selesai" 
                                        html-for="is_completed"
                                        :required="true"
                                        class="ml-2"
                                    />
                                </label>
                                <p v-if="form.errors.is_completed" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.is_completed }}
                                </p>
                            </div>

                            <div class="flex items-center justify-end mt-4 space-x-2">
                                <SubmitButton 
                                    :processing="isProcessing" 
                                    :disabled="!form.isDirty" 
                                    @click="handleSubmit"
                                    label="Perbarui" 
                                />
                                <ActionLink 
                                    :href="route('admin.member-inductions.index')" 
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