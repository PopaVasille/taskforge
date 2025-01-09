<!-- resources/js/Components/Common/Toast.vue -->
<script setup>
import { CheckCircle, AlertCircle, X } from 'lucide-vue-next';
import { ref, onMounted } from 'vue';

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: 'success' // sau 'error'
    },
    duration: {
        type: Number,
        default: 3000
    }
});

const isVisible = ref(true);

onMounted(() => {
    setTimeout(() => {
        isVisible.value = false;
    }, props.duration);
});
</script>

<template>
    <div
        v-if="isVisible"
        class="fixed bottom-4 right-4 flex items-center p-4 rounded-lg shadow-lg z-50"
        :class="{
            'bg-green-100 text-green-800': type === 'success',
            'bg-red-100 text-red-800': type === 'error'
        }"
    >
        <CheckCircle v-if="type === 'success'" class="w-5 h-5 mr-2" />
        <AlertCircle v-else class="w-5 h-5 mr-2" />

        <p class="mr-4">{{ message }}</p>

        <button
            @click="isVisible = false"
            class="p-1 hover:opacity-75"
        >
            <X class="w-4 h-4" />
        </button>
    </div>
</template>
