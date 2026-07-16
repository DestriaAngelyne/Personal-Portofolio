<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useThreeBackground } from '@/composables/useThreeBackground';

const canvasRef = ref(null);
const { init, dispose } = useThreeBackground(canvasRef);

onMounted(() => init());
onBeforeUnmount(() => dispose());
</script>

<template>
    <canvas ref="canvasRef" class="absolute inset-0 w-full h-full pointer-events-none" />
</template>
