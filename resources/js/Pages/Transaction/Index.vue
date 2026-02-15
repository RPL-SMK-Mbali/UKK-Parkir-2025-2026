<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    attr: {
        type: Object,
        default: () => ({}),
        required: true
    }
});
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Area Parkir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Parkir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Kapasitas Area Parkir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Tipe Area Parkir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(item, index) in attr?.models?.data" :key="index">
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item?.rate?.name }} - {{ item?.rate?.hourlyRateAt }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ item?.capacity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ item?.typeAt }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <Link :href="route('transactions.edit', {transaction: item?.id, area_type: 'in'})" class="text-indigo-600 hover:text-indigo-900 mr-2">Pintu Masuk</Link>
                                <Link :href="route('transactions.edit', {transaction: item?.id, area_type: 'out'})" class="text-indigo-600 hover:text-indigo-900 mr-2">Pintu Keluar</Link>
                            </td>
                        </tr>
                        <!-- more rows -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
