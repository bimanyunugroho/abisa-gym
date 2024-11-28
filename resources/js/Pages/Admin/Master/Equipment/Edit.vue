<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import CustomSelect from '@/Components/Inputs/CustomSelect.vue';
import CustomDatePicker from '@/Components/Inputs/CustomDatePicker.vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInputUppercase from '@/Components/Inputs/TextInputUppercase.vue';
import TextArea from '@/Components/Inputs/TextArea.vue';
import Checkbox from '@/Components/Inputs/Checkbox.vue';
import SubmitButton from '@/Components/Buttons/SubmitButton.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import LabelRequired from '@/Components/Helpers/LabelRequired.vue';

const { props } = usePage();
const { title, desc, conditionLevels, equipmentCategories, equipment, errors: pageErrors } = props;
const toast = useToast();

// Inisialisasi form dengan data equipment yang ada
const form = useForm({
    category_id: equipment.category_id,
    name: equipment.name,
    description: equipment.description,
    usage_instructions: equipment.usage_instructions,
    brand: equipment.brand,
    model: equipment.model,
    purchase_date: equipment.purchase_date,
    last_maintenance_date: equipment.last_maintenance_date,
    condition: equipment.condition,
    is_active: equipment.is_active
});

// Menyalin semua error dari pageErrors ke form.errors
Object.keys(pageErrors).forEach(key => {
    if (pageErrors[key]) {
        form.errors[key] = pageErrors[key];
    }
});

const isProcessing = ref(false);

function handleSubmit() {
    console.log('Form data:', form.data());
    isProcessing.value = true;
    
    // Menggunakan method patch untuk update
    router.patch(route('admin.equipments.update', equipment.slug), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Data alat berhasil diperbarui!');
            isProcessing.value = false;
        },
        onError: (errors) => {
            form.errors = errors;
            toast.error('Ooppss... Terjadi kesalahan!');
            isProcessing.value = false;
        }
    });
}

const breadcrumbItems = [
  { label: 'Home', href: '/' },
  { label: 'Master Alat', href: route('admin.equipments.index') },
  { label: 'Edit', href: '#' },
];
</script>

<template>
    <Head :title="`Edit ${title}`" />

    <AuthenticatedLayout>
        <div class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Breadcrumb :items="breadcrumbItems" />
                <div class="bg-white dark:bg-dark-default overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="handleSubmit">
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Nama Alat" 
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
                                    placeholder="Masukkan nama alat" 
                                />
                                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Model" 
                                    html-for="model"
                                    :required="true" 
                                />
                                <TextInputUppercase 
                                    id="model" 
                                    v-model="form.model" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    required
                                    placeholder="Masukkan model alat" 
                                />
                                <p v-if="form.errors.model" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.model }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Brand" 
                                    html-for="brand"
                                    :required="true" 
                                />
                                <TextInputUppercase 
                                    id="brand" 
                                    v-model="form.brand" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    required
                                    placeholder="Masukkan brand alat" 
                                />
                                <p v-if="form.errors.brand" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.brand }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Pembelian" 
                                    html-for="purchase_date"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.purchase_date"
                                    placeholder="Pilih tanggal pembelian"
                                />
                                <p v-if="form.errors.purchase_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.purchase_date }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Pemeliharan Akhir" 
                                    html-for="last_maintenance_date"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.last_maintenance_date"
                                    placeholder="Pilih tanggal pemeliharan akhir"
                                />
                                <p v-if="form.errors.last_maintenance_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.last_maintenance_date }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Kategori" 
                                    html-for="category_id"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.category_id"
                                    :options="equipmentCategories"
                                    :reduce="option => option.id"
                                    label="name"
                                    placeholder="Pilih kategori"
                                />
                                <p v-if="form.errors.category_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.category_id }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Kondisi" 
                                    html-for="condition"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.condition"
                                    :options="conditionLevels"
                                    :reduce="option => option.value"
                                    label="label"
                                    placeholder="Pilih kondisi"
                                />
                                <p v-if="form.errors.condition" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.condition }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Instruksi Penggunaan" 
                                    html-for="usage_instructions"
                                    :required="true" 
                                />
                                <TextArea 
                                    id="usage_instructions" 
                                    v-model="form.usage_instructions" 
                                    class="mt-1 block w-full" 
                                    placeholder="Masukkan instruksi penggunaan alat" 
                                />
                                <p v-if="form.errors.usage_instructions" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.usage_instructions }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Deskripsi" 
                                    html-for="description"
                                    :required="true" 
                                />
                                <TextArea 
                                    id="description" 
                                    v-model="form.description" 
                                    class="mt-1 block w-full" 
                                    placeholder="Masukkan deskripsi alat" 
                                />
                                <p v-if="form.errors.description" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.description }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center">
                                    <Checkbox
                                        id="is_active"
                                        name="is_active"
                                        v-model="form.is_active"
                                        :checked="form.is_active"
                                    />
                                    <label 
                                        for="is_active" 
                                        class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer"
                                    >
                                        Status Aktif
                                    </label>
                                </div>
                                <p v-if="form.errors.is_active" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.is_active }}
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
                                    :href="route('admin.equipments.index')" 
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