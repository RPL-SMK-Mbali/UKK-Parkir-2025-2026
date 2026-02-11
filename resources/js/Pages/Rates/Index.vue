<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';

const props = defineProps({
    attr: {
        type: Object,
        default: () => ({}),
        required: true
    }
});

</script>

<template>
    <AppLayout title="Profile">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Header 1</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Header 2</th>
                            <!-- more headers -->
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Data 1</td>
                            <td class="px-6 py-4 whitespace-nowrap">Data 2</td>
                            <!-- more data cells -->
                        </tr>
                        <!-- more rows -->
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
    </AppLayout>
</template>
