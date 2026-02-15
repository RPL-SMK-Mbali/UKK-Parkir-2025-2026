<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const deleteForm = useForm({});
const beingDeleted = ref(null);

const props = defineProps({
    attr: {
        type: Object,
        default: () => ({}),
        required: true
    }
});

const deleteModel = (id) => {
    deleteForm.delete(route('rates.destroy', id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (beingDeleted.value = null),
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

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="my-2">
                    <PrimaryLink 
                        :href="attr?.route_create"
                        class=""
                    >Tambah</PrimaryLink>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tarif Parkir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Parkir Per Jam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(item, index) in attr?.models?.data" :key="index">
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.hourly_rate }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <Link :href="route('rates.edit', item?.id)" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</Link>
                                <button @click="beingDeleted = item?.id" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                        <!-- more rows -->
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>

         <ConfirmationModal :show="beingDeleted != null" @close="beingDeleted = null">
            <template #title>
                Delete
            </template>

            <template #content>
                Apakah anda yakin ingin menghapus data ini?
            </template>

            <template #footer>
                <SecondaryButton @click="beingDeleted = null">
                    Batal
                </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    :class="{ 'opacity-25': deleteForm.processing }"
                    :disabled="deleteForm.processing"
                    @click="deleteModel(beingDeleted)"
                >
                    Hapus
                </DangerButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
