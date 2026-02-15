<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    attr: {
        type: Object,
        default: () => ({}),
        required: true
    }
});

const form = useForm({
    _method: props?.attr?.form_type,
    area_type: props?.attr?.area_type,
    vehicle_id: '',
});

const formattedInput = computed({
  get: () => inputValue.value,
  set: (val) => {
    inputValue.value = val.toUpperCase().replace(/[^A-Z0-9]/g, '');
  }
});

const formModel = () => {
    form.post(props?.attr?.route_url, {
        errorBag: 'formModel',
        preserveScroll: true,
        onSuccess: () => form.vehicle_id = '',
        onError: () => {
            //
        },
    });
};

</script>

<template>
    <AppLayout :title="attr?.title">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ attr?.title }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <FormSection @submitted="formModel">
                    <template #title>
                        {{ attr?.title }}
                    </template>

                    <template #description>
                        Input Data Transaksi {{ attr?.title }}
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="vehicle_id" value="Nomor Kendaraan" />
                            <TextInput
                                id="vehicle_id"
                                v-model="form.vehicle_id"
                                type="text"
                                class="mt-1 block w-full"
                                @input="form.vehicle_id = $event.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '')"
                                placeholder="Ex: B1234AB"
                            />
                            <InputError :message="form.errors.vehicle_id" class="mt-2" />
                        </div>
                    </template>

                    <template #actions>
                        <ActionMessage :on="form.recentlySuccessful" class="me-3">
                            Saved.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </template>
                </FormSection>

                <div class="overflow-x-auto mt-5">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Area Parkir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(item, index) in attr?.models" :key="index">
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.parking_area?.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.vehicle_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.date_in }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.date_out }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.minutes_duration }} menit</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.amountAt }}</td>
                        </tr>
                        <!-- more rows -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
