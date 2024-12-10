<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import CustomSelect from '@/Components/Inputs/CustomSelect.vue';
import CustomDatePicker from '@/Components/Inputs/CustomDatePicker.vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextArea from '@/Components/Inputs/TextArea.vue';
import TextInputUppercase from '@/Components/Inputs/TextInputUppercase.vue';
import TextInput from '@/Components/Inputs/TextInput.vue';
import SubmitButton from '@/Components/Buttons/SubmitButton.vue';
import ActionLink from '@/Components/Buttons/ActionLink.vue';
import Breadcrumb from '@/Components/Helpers/Breadcrumb.vue';
import LabelRequired from '@/Components/Helpers/LabelRequired.vue';
import PhoneInput from '@/Components/Inputs/PhoneInput.vue';

const { props } = usePage();
const { title, desc, roles, genders, member, errors: pageErrors } = props;
const toast = useToast();
const form = useForm({
    name: member.name,
    email: member.email,
    role: member.role,
    phone_number: member.phone_number,
    address: member.address,
    birth_date: member.birth_date,
    gender: member.gender,
    health_conditions: member.health_conditions,
    emergency_contact: member.emergency_contact,
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
    router.put(route('admin.members.update', member.slug), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Anggota berhasil diubah!');
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
  { label: 'Anggota', href: route('admin.members.index') },
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
                                    text="Nama" 
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
                                    placeholder="Masukkan nama" 
                                />
                                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.name }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Email" 
                                    html-for="email"
                                    :required="true" 
                                />
                                <TextInput 
                                    id="email" 
                                    v-model="form.email" 
                                    type="email" 
                                    class="mt-1 block w-full" 
                                    required
                                    placeholder="Masukkan email" 
                                />
                                <p v-if="form.errors.email" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Gender" 
                                    html-for="gender"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.gender"
                                    :options="genders"
                                    :reduce="option => option.value"
                                    label="label"
                                    placeholder="Pilih gender"
                                />
                                <p v-if="form.errors.gender" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.gender }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="No.Telp" 
                                    html-for="phone_number"
                                    :required="true"
                                />
                                <PhoneInput
                                    id="phone_number"
                                    v-model="form.phone_number"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.phone_number" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.phone_number }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Kontak Darurat" 
                                    html-for="emergency_contact"
                                    :required="true"
                                />
                                <PhoneInput
                                    id="emergency_contact"
                                    v-model="form.emergency_contact"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.emergency_contact" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.emergency_contact }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Lahir" 
                                    html-for="birth_date"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.birth_date"
                                    placeholder="Pilih tanggal lahir"
                                />
                                <p v-if="form.errors.birth_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.birth_date }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Kondisi Kesehatan" 
                                    html-for="health_conditions"
                                    :required="true" 
                                />
                                <TextArea 
                                    id="health_conditions" 
                                    v-model="form.health_conditions" 
                                    class="mt-1 block w-full" 
                                    placeholder="Masukkan kondisi kesehatan" 
                                />
                                <p v-if="form.errors.health_conditions" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.health_conditions }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Alamat" 
                                    html-for="address"
                                    :required="true" 
                                />
                                <TextArea 
                                    id="address" 
                                    v-model="form.address" 
                                    class="mt-1 block w-full" 
                                    placeholder="Masukkan alamat" 
                                />
                                <p v-if="form.errors.address" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.address }}
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
                                    :href="route('admin.members.index')" 
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