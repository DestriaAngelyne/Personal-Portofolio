<script setup>
import { onMounted, onBeforeUnmount } from 'vue';
import { useParticles } from '@/composables/useParticles';

const CONTAINER_ID = 'tsparticles-global-bg';
const { init, dispose } = useParticles();

onMounted(() => init(CONTAINER_ID));
onBeforeUnmount(() => dispose(CONTAINER_ID));
</script>

<template>
    <div :id="CONTAINER_ID" class="absolute inset-0 w-full h-full pointer-events-none" />
</template>
