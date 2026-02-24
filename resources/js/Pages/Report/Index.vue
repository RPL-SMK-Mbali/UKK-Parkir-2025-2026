<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';

const iframeStatus = ref(false);
const iframeKey = ref(null);

const props = defineProps({
    attr: {
        type: Object,
        default: () => ({}),
        required: true
    }
});

function onloadPage() {
	iframeStatus.value = true;
}

onMounted(() => {
	iframeStatus.value = false;
	iframeKey.value = Math.floor(Math.random() * 1000);
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
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-200 p-4">
                        <label for="from_date">Dari Tanggal</label>
                        <input 
                            id="from_date" 
                            type="date" 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            :value="attr?.start"
                        />
                    </div>
                    <div class="bg-gray-200 p-4">
                        <label for="to_date">Sampai Tanggal</label>
                        <input 
                            id="to_date" 
                            type="date" 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            :value="attr?.end"
                        />
                    </div>
                </div>

                <div class="">
                    <iframe v-show="iframeStatus" class="w-full h-screen" :src="attr?.reports" @load="onloadPage()" :key="iframeKey"></iframe>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
