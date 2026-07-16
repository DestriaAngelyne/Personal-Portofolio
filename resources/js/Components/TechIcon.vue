<script setup>
import { Icon } from "@iconify/vue";

defineProps({
    icon: String,
});

const icons = {
    vue: "logos:vue",
    js: "logos:javascript",
    tailwind: "logos:tailwindcss-icon",
    laravel: "logos:laravel",
    php: "logos:php",
    mysql: "logos:mysql",
    git: "logos:git-icon",
    github: "logos:github-icon",
    react: "logos:react",
    ts: "logos:typescript-icon",
    html5: "logos:html-5",
    css3: "logos:css-3",
    figma: "logos:figma",
    vscode: "logos:visual-studio-code",
    inertia: "logos:inertiajs-icon",
};
</script>

<template>
    <Icon
        :icon="icons[icon]"
        class="w-full h-full transition-all duration-300"
    />
</template>
