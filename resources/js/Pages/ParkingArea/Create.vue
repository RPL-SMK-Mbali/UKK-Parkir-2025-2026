<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectOption from '@/Components/SelectOption.vue';

const props = defineProps({
    attr: {
        type: Object,
        default: () => ({}),
        required: true
    }
});

const form = useForm({
    _method: props?.attr?.form_type,
    rate_id: props?.attr?.model?.rate_id ?? '',
    name: props?.attr?.model?.name ?? '',
    capacity: props?.attr?.model?.capacity ?? '',
    type: props?.attr?.model?.type ?? ''
});

const formModel = () => {
    form.post(props?.attr?.route_url, {
        errorBag: 'formModel',
        preserveScroll: true,
        onSuccess: () => form.reset(),
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
                        Input Data Tarif Parkir
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="rate_id" value="Tarif Parkir" />
                            <SelectOption
                                id="rate_id"
                                v-model="form.rate_id"
                                class="mt-1 block w-full"
                                :options="attr?.rates"
                            />
                            <InputError :message="form.errors.rate_id" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Nama Area Parkir" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="name"
                            />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="capacity" value="Kapasitas Area Parkir" />
                            <TextInput
                                id="capacity"
                                v-model="form.capacity"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="capacity"
                            />
                            <InputError :message="form.errors.capacity" class="mt-2" />
                        </div>
                        
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="type" value="Tipe Area Parkir" />
                            <SelectOption
                                id="type"
                                v-model="form.type"
                                class="mt-1 block w-full"
                                :options="attr?.types"
                            />
                            <InputError :message="form.errors.capacity" class="mt-2" />
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
            </div>
        </div>
    </AppLayout>
</template>
