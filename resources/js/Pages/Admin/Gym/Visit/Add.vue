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
const { title, desc, users, memberRegistrations, visitTypes, guests, errors: pageErrors } = props;
const toast = useToast();
const form = useForm({
    user_id: '',
    member_registration_id: '',
    guest_of: '',
    check_in_time: new Date().toISOString().split('T')[0],
    check_out_time: new Date().toISOString().split('T')[0],
    visit_type: 'ACTIVE',
    paid_amount: '',
    notes: '',
});

console.log(memberRegistrations);


watch(() => form.member_registration_id, (newMemberRegistrationId) => {
    if (newMemberRegistrationId) {
        const selectedMemberRegistration = memberRegistrations.find(memberRegistration => memberRegistration.id === newMemberRegistrationId);
        form.user_id = selectedMemberRegistration.user_id;

        const selectedMembershipPlan = selectedMemberRegistration.membership_plan;
        form.paid_amount = Number(selectedMembershipPlan.price || 0).toFixed(0);
    }
}, { immediate: true });

watch(() => form.guest_of, (newGuestId) => {
    if (newGuestId && form.member_registration_id) {
        const selectedMemberRegistration = memberRegistrations.find(memberRegistration => memberRegistration.id === form.member_registration_id);
        const guestFee = selectedMemberRegistration.membership_plan.member_level.guest_fee || 0;
        const planPrice = Number(selectedMemberRegistration.membership_plan.price || 0);
        
        form.paid_amount = (planPrice + Number(guestFee)).toFixed(0);
    } else if (form.member_registration_id) {
        const selectedMemberRegistration = memberRegistrations.find(memberRegistration => memberRegistration.id === form.member_registration_id);
        form.paid_amount = Number(selectedMemberRegistration.membership_plan.price || 0).toFixed(0);
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
    router.post(route('admin.gym-visits.store'), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Data Kunjungan Gym berhasil disimpan!');
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
  { label: 'Kunjungan Gym', href: route('admin.gym-visits.index') },
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
                                    text="Member Registration" 
                                    html-for="member_registration_id"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.member_registration_id"
                                    :options="memberRegistrations"
                                    :reduce="option => option.id"
                                    :get-option-label="option => `${option.user.name} - ${option.membership_plan.name}`"
                                    placeholder="Pilih member registration"
                                />
                                <p v-if="form.errors.member_registration_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.member_registration_id }}
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
                                    label="name"
                                    placeholder="Pilih anggota"
                                />
                                <p v-if="form.errors.user_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.user_id }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Apakah Membawa Tamu ?" 
                                    html-for="guest_of"
                                    :required="false" 
                                />
                                <CustomSelect
                                    v-model="form.guest_of"
                                    :options="guests"
                                    :reduce="option => option.id"
                                    label="name"
                                    placeholder="Pilih guest"
                                />
                                <p v-if="form.errors.guest_of" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.guest_of }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Jenis Kunjungan" 
                                    html-for="visit_type"
                                    :required="true" 
                                />
                                <CustomSelect
                                    v-model="form.visit_type"
                                    :options="visitTypes"
                                    :reduce="option => option.value"
                                    label="label"
                                    placeholder="Pilih jenis kunjungan"
                                />
                                <p v-if="form.errors.visit_type" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.visit_type }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Masuk" 
                                    html-for="check_in_time"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.check_in_time"
                                    placeholder="Pilih tanggal masuk"
                                />
                                <p v-if="form.errors.check_in_time" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.check_in_time }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <LabelRequired 
                                    text="Tanggal Selesai" 
                                    html-for="check_out_time"
                                    :required="true" 
                                />
                                <CustomDatePicker
                                    v-model="form.check_out_time"
                                    placeholder="Pilih tanggal selesai"
                                />
                                <p v-if="form.errors.check_out_time" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.check_out_time }}
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <LabelRequired 
                                    text="Jumlah Bayar" 
                                    html-for="paid_amount"
                                    :required="true"
                                />
                                <TextNumeric 
                                    id="paid_amount"
                                    v-model="form.paid_amount"
                                    class="mt-1 block w-full"
                                />
                                <p v-if="form.errors.paid_amount" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.paid_amount }}
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

                            <div class="flex items-center justify-end mt-4 space-x-2">
                                <SubmitButton 
                                    :processing="isProcessing" 
                                    :disabled="!form.isDirty" 
                                    @click="handleSubmit"
                                    label="Simpan" 
                                />
                                <ActionLink 
                                    :href="route('admin.gym-visits.index')" 
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