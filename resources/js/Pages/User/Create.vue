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
    name: props?.attr?.model?.name ?? '',
    email: props?.attr?.model?.email ?? '',
    password: null,
    role: props?.attr?.model?.role ?? ''
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
                            <InputLabel for="name" value="Nama" />
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
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="email"
                            />
                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>
                        
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="password" value="Password" />
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="password"
                            />
                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>
                        
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="role" value="Role" />
                            <SelectOption
                                id="role"
                                v-model="form.role"
                                class="mt-1 block w-full"
                                :options="attr?.roles"
                            />
                            <InputError :message="form.errors.role" class="mt-2" />
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
