<script setup>
import { ref, computed, watch } from 'vue';
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
import TextArea from '@/Components/Inputs/TextArea.vue';

const { props } = usePage();
const { title, desc, users, statuses, paymentTypes, gymVisits, paymentMethods, errors: pageErrors } = props;
const toast = useToast();
const form = useForm({
    user_id: '',
    payable_id: '',
    payable_type: '',
    amount: '',
    payment_method: '',
    payment_type: '',
    status: '',
    notes: '',
});

// Watch untuk gym_visit yang dipilih
watch(() => form.payable_id, (newValue) => {
    if (newValue) {
        // Cari data gym visit yang dipilih
        const selectedVisit = gymVisits.find(visit => visit.id === newValue);
        if (selectedVisit) {
            // Set user_id dan amount dari gym visit yang dipilih
            form.user_id = selectedVisit.user_id;
            form.amount = Number(selectedVisit.paid_amount) || 0;
            form.payable_type = 'App\\Models\\GymVisit';
        }
    }
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
    router.post(route('admin.payments.store'), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Data Pembayaran berhasil disimpan!');
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
  { label: 'Pembayaran', href: route('admin.payments.index') },
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
                                    text="Data Kunjungan" 
                                    html-for="payable_id"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.payable_id"
                                    :options="gymVisits"
                                    :reduce="option => option.id"
                                    :get-option-label="option => `${option.user?.name} - ${option.check_in_time}`"
                                    placeholder="Pilih data kunjungan"
                                />
                                <p v-if="form.errors.payable_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.payable_id }}
                                </p>
                            </div>
                            
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
                                    :get-option-label="option => option.name"
                                    placeholder="Pilih member"
                                    readonly
                                />
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Jenis Pembayaran" 
                                    html-for="payment_type"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.payment_type"
                                    :options="paymentTypes"
                                    :reduce="option => option.value"
                                    label="label"
                                    placeholder="Pilih jenis pembayaran"
                                />
                                <p v-if="form.errors.payment_type" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.payment_type }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Metode Pembayaran" 
                                    html-for="payment_method"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.payment_method"
                                    :options="paymentMethods"
                                    :reduce="option => option.value"
                                    label="label"
                                    placeholder="Pilih metode pembayaran"
                                />
                                <p v-if="form.errors.payment_method" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.payment_method }}
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
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Jumlah Pembayaran" 
                                    html-for="amount"
                                    :required="true"
                                />
                                <TextNumeric 
                                    id="amount"
                                    v-model="form.amount"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.amount" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.amount }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Catatan" 
                                    html-for="notes"
                                    :required="false" 
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

                            <div class="flex items-center justify-end mt-4 space-x-2">
                                <SubmitButton 
                                    :processing="isProcessing" 
                                    :disabled="!form.isDirty" 
                                    @click="handleSubmit"
                                    label="Simpan" 
                                />
                                <ActionLink 
                                    :href="route('admin.payments.index')" 
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