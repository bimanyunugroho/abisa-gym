<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import CustomSelect from '@/Components/Inputs/CustomSelect.vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInputUppercase from '@/Components/Inputs/TextInputUppercase.vue';
import SubmitButton from '@/Components/Buttons/SubmitButton.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import LabelRequired from '@/Components/Helpers/LabelRequired.vue';

const { props } = usePage();
const { title, desc, difficultyLevels, equipmentCategory, errors: pageErrors } = props;
const toast = useToast();
const form = useForm({
    name: equipmentCategory.name,
    difficulty_level: equipmentCategory.difficulty_level,
    needs_supervision: equipmentCategory.needs_supervision,
    _method: 'PUT'
});

Object.keys(pageErrors).forEach(key => {
    if (pageErrors[key]) {
        form.errors[key] = pageErrors[key];
    }
});

const isProcessing = ref(false);

function handleSubmit() {
    isProcessing.value = true;
    router.post(route('admin.equipment-categories.update', equipmentCategory.slug), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Data kategori alat berhasil diperbarui!');
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
  { label: 'Master Kategori Alat', href: route('admin.equipment-categories.index') },
  { label: 'Edit', href: '#' },
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
                                    text="Nama Kategori" 
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
                                    placeholder="Masukkan nama kategori" 
                                />
                                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tingkat Kesulitan" 
                                    html-for="difficulty_level"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.difficulty_level"
                                    :options="difficultyLevels"
                                    :reduce="option => option.value"
                                    label="label"
                                    placeholder="Pilih tingkat kesulitan"
                                />
                                <p v-if="form.errors.difficulty_level" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.difficulty_level }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        v-model="form.needs_supervision"
                                        class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500"
                                    >
                                    <LabelRequired 
                                        text="Membutuhkan Pengawasan" 
                                        html-for="needs_supervision"
                                        :required="true"
                                        class="ml-2"
                                    />
                                </label>
                                <p v-if="form.errors.needs_supervision" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.needs_supervision }}
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
                                    :href="route('admin.equipment-categories.index')" 
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