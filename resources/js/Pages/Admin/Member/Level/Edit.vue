<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextArea from '@/Components/Inputs/TextArea.vue';
import SubmitButton from '@/Components/Buttons/SubmitButton.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import LabelRequired from '@/Components/Helpers/LabelRequired.vue';
import Checkbox from '@/Components/Inputs/Checkbox.vue';
import TextNumeric from '@/Components/Inputs/TextNumeric.vue';
import TextInputUppercase from '@/Components/Inputs/TextInputUppercase.vue';

const { props } = usePage();
const { title, desc, memberLevel, errors: pageErrors } = props;
const toast = useToast();
const form = useForm({
    'name': memberLevel.name,
    'description': memberLevel.description,
    'can_train_without_trainer': memberLevel.can_train_without_trainer,
    'needs_orientation': memberLevel.needs_orientation,
    'has_trainer_access': memberLevel.has_trainer_access,
    'max_guests': memberLevel.max_guests,
    'guest_fee': memberLevel.guest_fee,
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
    router.put(route('admin.member-levels.update', memberLevel.slug), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Level anggota berhasil diubah!');
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
  { label: 'Level Anggota', href: route('admin.member-levels.index') },
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
                                    text="Nama Level" 
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
                                    placeholder="Masukkan nama level" 
                                />
                                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <Checkbox
                                        id="can_train_without_trainer"
                                        name="can_train_without_trainer"
                                        v-model="form.can_train_without_trainer"
                                        :checked="form.can_train_without_trainer"
                                    />
                                    <LabelRequired 
                                        text="Dapat latihan tanpa instruktur" 
                                        html-for="can_train_without_trainer"
                                        :required="true"
                                        class="ml-2"
                                    />
                                </label>
                                <p v-if="form.errors.can_train_without_trainer" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.can_train_without_trainer }}
                                </p>
                            </div>


                            <div class="mb-4">
                                <label class="flex items-center">
                                    <Checkbox
                                        id="needs_orientation"
                                        name="needs_orientation"
                                        v-model="form.needs_orientation"
                                        :checked="form.needs_orientation"
                                    />
                                    <LabelRequired 
                                        text="Membutuhkan orientasi" 
                                        html-for="needs_orientation"
                                        :required="true"
                                        class="ml-2"
                                    />
                                </label>
                                <p v-if="form.errors.needs_orientation" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.needs_orientation }}
                                </p>
                            </div>


                            <div class="mb-4">
                                <label class="flex items-center">
                                    <Checkbox
                                        id="has_trainer_access"
                                        name="has_trainer_access"
                                        v-model="form.has_trainer_access"
                                        :checked="form.has_trainer_access"
                                    />
                                    <LabelRequired 
                                        text="Memiliki akses instruktur" 
                                        html-for="has_trainer_access"
                                        :required="true"
                                        class="ml-2"
                                    />
                                </label>
                                <p v-if="form.errors.has_trainer_access" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.has_trainer_access }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Maksimal tamu" 
                                    html-for="max_guests"
                                    :required="true"
                                />
                                <TextNumeric 
                                    id="max_guests"
                                    v-model="form.max_guests"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.max_guests" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.max_guests }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Biaya tamu" 
                                    html-for="guest_fee"
                                    :required="true"
                                />

                                <TextNumeric 
                                    id="guest_fee"
                                    v-model="form.guest_fee"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.guest_fee" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.guest_fee }}
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
                                    placeholder="Masukkan deskripsi" 
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
                                    label="Perbarui" 
                                />
                                <ActionLink 
                                    :href="route('admin.member-levels.index')" 
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