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
import Checkbox from '@/Components/Inputs/Checkbox.vue';

const { props } = usePage();
const { title, desc, users, membershipPlans, statuses, memberRegistration, errors: pageErrors } = props;
const toast = useToast();

const form = useForm({
    'user_id': memberRegistration.user_id,
    'membership_plan_id': memberRegistration.membership_plan_id,
    'start_date': memberRegistration.start_date,
    'end_date': memberRegistration.end_date,
    'visits_left': memberRegistration.visits_left,
    'status': memberRegistration.status,
    'orientation_date': memberRegistration.orientation_date,
    'orientation_completed': memberRegistration.orientation_completed,
});

watch(() => form.membership_plan_id, (newPlanId) => {
    if (newPlanId) {
        const selectedPlan = membershipPlans.find(plan => plan.id === newPlanId);
        if (selectedPlan) {
            form.visits_left = selectedPlan.visit_limit;
            const startDate = new Date(form.start_date);
            const endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + selectedPlan.duration_days);
            form.end_date = endDate.toISOString().split('T')[0];
        }
    }
}, { immediate: true });

// Menyalin semua error dari pageErrors ke form.errors
Object.keys(pageErrors).forEach(key => {
    if (pageErrors[key]) {
        form.errors[key] = pageErrors[key];
    }
});

const isProcessing = ref(false);

function handleSubmit() {
    isProcessing.value = true;
    router.put(route('admin.member-registrations.update', memberRegistration.slug), form, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Data registrasi berhasil diperbarui!');
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
                                    :disabled="true"
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
                                    :disabled="true"
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
                                    readonly
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

                            <div class="mb-4">
                                <label class="flex items-center">
                                    <Checkbox
                                        id="orientation_completed"
                                        name="orientation_completed"
                                        v-model="form.orientation_completed"
                                        :checked="form.orientation_completed"
                                    />
                                    <LabelRequired 
                                        text="Orientasi Selesai" 
                                        html-for="orientation_completed"
                                        :required="true"
                                        class="ml-2"
                                    />
                                </label>
                                <p v-if="form.errors.orientation_completed" class="mt-2 text-sm text-red-600 dark:text-red-400">
                                    {{ form.errors.orientation_completed }}
                                </p>
                            </div>

                            <div class="flex items-center justify-end mt-4 space-x-2">
                                <SubmitButton 
                                    :processing="isProcessing" 
                                    :disabled="!form.isDirty" 
                                    @click="handleSubmit"
                                    label="Update" 
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