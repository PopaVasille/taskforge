// resources/js/Composables/useToast.js
import { ref } from 'vue';

const toast = ref(null);

export function useToast() {
    const showToast = (message, type = 'success', duration = 3000) => {
        toast.value = {
            message,
            type,
            duration
        };

        setTimeout(() => {
            toast.value = null;
        }, duration);
    };

    return {
        toast,
        showToast
    };
}
