<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ThreeBackground from '@/Components/Background/ThreeBackground.vue';
import ParticleBackground from '@/Components/Background/ParticleBackground.vue';
import TechIcon from '@/Components/TechIcon.vue';

const activeLink = ref('#home');
const mobileMenuOpen = ref(false);

const scrollProgress = ref(0);
const showBackToTop = ref(false);

function updateScrollProgress() {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    scrollProgress.value = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    showBackToTop.value = scrollTop > 600;
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

const navLinks = [
    { name: 'Beranda', href: '#home' },
    { name: 'Tentang', href: '#about' },
    { name: 'Pendidikan', href: '#education' },
    { name: 'Keahlian', href: '#skills' },
    { name: 'Proyek', href: '#projects' },
    { name: 'Soft Skills', href: '#soft-skills' },
    { name: 'Kontak', href: '#contact' },
];

function selectLink(href) {
    activeLink.value = href;
    mobileMenuOpen.value = false;
}

let sectionObserver;
onMounted(() => {
    const sections = navLinks
        .map((link) => document.querySelector(link.href))
        .filter(Boolean);

    sectionObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    activeLink.value = '#' + entry.target.id;
                }
            });
        },
        { rootMargin: '-45% 0px -50% 0px', threshold: 0 }
    );

    sections.forEach((section) => sectionObserver.observe(section));

    window.addEventListener('scroll', updateScrollProgress, { passive: true });
    updateScrollProgress();
});

onUnmounted(() => {
    if (sectionObserver) sectionObserver.disconnect();
    window.removeEventListener('scroll', updateScrollProgress);
});

const props = defineProps({
    profile: { type: Object, default: () => ({}) },
    educations: { type: Array, default: () => [] },
    techFrontend: { type: Array, default: () => [] },
    techBackend: { type: Array, default: () => [] },
    projects: { type: Array, default: () => [] },
    softSkills: { type: Array, default: () => [] },
    socialLinks: { type: Array, default: () => [] },
});

function socialUrl(platform) {
    return props.socialLinks?.find((s) => s.platform === platform)?.url ?? '#';
}

function techIconUrl(tech) {
    if (tech.icon_source === 'devicon') {
        return `https://cdn.jsdelivr.net/gh/devicons/devicon/icons/${tech.icon_key}/${tech.icon_key}-original.svg`;
    }
    return `https://cdn.simpleicons.org/${tech.icon_key}`;
}

function handleIconError(event) {
    event.target.style.display = 'none';
    const fallback = event.target.nextElementSibling;
    if (fallback) fallback.style.display = 'flex';
}

function handleSpotlight(event) {
    const card = event.currentTarget;
    const rect = card.getBoundingClientRect();
    card.style.setProperty('--mouse-x', `${event.clientX - rect.left}px`);
    card.style.setProperty('--mouse-y', `${event.clientY - rect.top}px`);
}

const EASE = [0.22, 1, 0.36, 1];

const contactForm = useForm({
    name: '',
    email: '',
    message: '',
    website: '', // honeypot, harus tetap kosong
});

const contactSuccess = ref(false);

function submitContact() {
    contactForm.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            contactForm.reset('name', 'email', 'message');
            contactSuccess.value = true;
            setTimeout(() => {
                contactSuccess.value = false;
            }, 5000);
        },
    });
}
</script>

<template>
    <div class="relative min-h-screen bg-[#090909] text-white font-sans antialiased selection:bg-neutral-800 selection:text-white">

        <div class="fixed inset-0 z-0 overflow-hidden">
            <ThreeBackground />
            <ParticleBackground />
        </div>

        <div class="relative z-10">

        <div class="fixed top-0 left-0 h-[2px] bg-[#a3e635] z-[60] transition-[width] duration-150 ease-out" :style="{ width: scrollProgress + '%' }"></div>

        <nav
            v-motion
            :initial="{ opacity: 0, y: -16 }"
            :enter="{ opacity: 1, y: 0, transition: { duration: 500, ease: EASE } }"
            class="sticky top-0 z-50 w-full bg-[#090909]/90 backdrop-blur-md border-b border-[#262626] transition-colors duration-200"
        >
            <div class="max-w-[1320px] mx-auto h-[72px] px-6 lg:px-[42px] flex items-center justify-between relative">

                <div class="flex-shrink-0 z-10">
                    <a href="#home" @click="selectLink('#home')" class="text-[25px] font-bold tracking-tight text-white select-none focus:outline-none">
                        DA<span class="text-neutral-400">.</span>
                    </a>
                </div>

                <div class="hidden xl:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 items-center gap-1">
                    <a
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        @click="selectLink(link.href)"
                        class="nav-link relative text-[13px] font-medium tracking-wide transition-colors duration-200 px-4 py-2 rounded-full focus:outline-none whitespace-nowrap"
                        :class="activeLink === link.href ? 'text-white' : 'text-[#A3A3A3] hover:text-white'"
                    >
                        <span
                            v-if="activeLink === link.href"
                            class="absolute inset-0 bg-white/[0.06] border border-[#262626] rounded-full"
                        />
                        <span class="relative">{{ link.name }}</span>
                        <span class="nav-underline"></span>
                    </a>
                </div>

                <div class="flex items-center gap-3 z-10">
                    <a
                        href="/download-cv"
                        class="hidden sm:inline-flex btn-sweep btn-sweep-primary items-center justify-center h-[44px] px-[24px] text-[13px] font-medium tracking-wide rounded-[8px] group focus:outline-none"
                    >
                        <span>Unduh CV</span>
                        <svg class="w-3.5 h-3.5 ml-2 stroke-[2.5] transform group-hover:translate-y-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </a>

                    <button
                        type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="xl:hidden w-10 h-10 flex items-center justify-center rounded-[8px] border border-[#262626] text-white focus:outline-none"
                        :aria-expanded="mobileMenuOpen"
                        aria-label="Buka menu navigasi"
                    >
                        <span class="hamburger" :class="{ 'is-open': mobileMenuOpen }">
                            <span class="hamburger-bar"></span>
                            <span class="hamburger-bar"></span>
                            <span class="hamburger-bar"></span>
                        </span>
                    </button>
                </div>
            </div>

            <Transition name="mobile-menu">
                <div v-if="mobileMenuOpen" class="xl:hidden border-t border-[#262626] bg-[#090909]/95 backdrop-blur-md overflow-hidden">
                    <div class="max-w-[1320px] mx-auto px-6 py-4 flex flex-col">
                        <a
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="link.href"
                            @click="selectLink(link.href)"
                            class="text-[14px] font-medium tracking-wide py-3 border-b border-[#1a1a1a] last:border-b-0 transition-colors duration-200 focus:outline-none"
                            :class="activeLink === link.href ? 'text-white' : 'text-[#A3A3A3] hover:text-white'"
                        >
                            {{ link.name }}
                        </a>
                        <a
                            href="/download-cv"
                            class="btn-sweep btn-sweep-primary inline-flex items-center justify-center h-[46px] mt-4 text-[13px] font-medium tracking-wide rounded-[8px]"
                        >
                            <span>Unduh CV</span>
                            <svg class="w-3.5 h-3.5 ml-2 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </Transition>
        </nav>

        <main class="max-w-[1320px] mx-auto px-6 lg:px-[42px] py-16 space-y-32">

            <section id="home" class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center pt-8">
                <div class="lg:col-span-7 space-y-6">
                    <div
                        v-motion
                        :initial="{ opacity: 0, y: 20 }"
                        :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 0, ease: EASE } }"
                        class="inline-flex items-center space-x-2 bg-[#111111] border border-[#262626] px-4 py-1.5 rounded-full"
                    >
                        <span class="relative flex w-1.5 h-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#a3e635] opacity-75"></span>
                            <span class="relative inline-flex w-1.5 h-1.5 rounded-full bg-white"></span>
                        </span>
                        <span class="text-xs font-medium tracking-wider text-[#A3A3A3] uppercase">Siswa Rekayasa Perangkat Lunak</span>
                    </div>

                    <h1
                        v-motion
                        :initial="{ opacity: 0, y: 28 }"
                        :enter="{ opacity: 1, y: 0, transition: { duration: 700, delay: 150, ease: EASE } }"
                        class="text-[48px] sm:text-[56px] lg:text-[64px] font-bold tracking-tight text-white leading-[1.1]"
                    >
                        Halo, Saya <br />
                        <span class="text-white">{{ props.profile?.name }}</span>
                    </h1>

                    <p
                        v-motion
                        :initial="{ opacity: 0, y: 24 }"
                        :enter="{ opacity: 1, y: 0, transition: { duration: 700, delay: 300, ease: EASE } }"
                        class="text-[16px] sm:text-[18px] text-[#A3A3A3] max-w-xl leading-relaxed"
                    >
                        Saya membangun aplikasi web yang bersih, fungsional, dan berfokus pada pengalaman pengguna dengan arsitektur kode yang terstruktur.
                    </p>

                    <div
                        v-motion
                        :initial="{ opacity: 0, y: 20 }"
                        :enter="{ opacity: 1, y: 0, transition: { duration: 600, delay: 450, ease: EASE } }"
                        class="flex flex-wrap gap-4 pt-2"
                    >
                        <a href="#projects" class="btn-sweep btn-sweep-primary inline-flex items-center justify-center h-[48px] px-6 text-[14px] font-medium tracking-wide rounded-[8px]">
                            <span>Lihat Proyek</span>
                            <svg class="w-4 h-4 ml-2 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </a>
                        <a href="#contact" class="btn-sweep btn-sweep-outline inline-flex items-center justify-center h-[48px] px-6 text-[14px] font-medium tracking-wide rounded-[8px]">
                            <span>Hubungi Saya</span>
                            <svg class="w-4 h-4 ml-2 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 flex justify-center relative">
                    <div
                        v-motion
                        :initial="{ opacity: 0, scale: 0.94, x: 24 }"
                        :enter="{ opacity: 1, scale: 1, x: 0, transition: { duration: 800, delay: 200, ease: EASE } }"
                        class="photo-glow group relative w-[340px] sm:w-[380px] aspect-[4/5] bg-[#111111] border border-[#262626] rounded-[12px] overflow-hidden"
                    >
                        <img
                            :src="props.profile?.photo_path ? `/storage/${props.profile.photo_path}` : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=500&q=80'"
                            alt="Foto Profil Destria Angelyne"
                            class="photo-reveal w-full h-full object-cover"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-[#090909] via-transparent to-transparent opacity-40"></div>
                    </div>

                    <div
                        v-motion
                        :initial="{ opacity: 0, y: 16, scale: 0.92 }"
                        :enter="{ opacity: 1, y: 0, scale: 1, transition: { duration: 600, delay: 700, ease: EASE } }"
                        class="absolute bottom-6 right-[-12px] bg-[#111111] border border-[#262626] px-5 py-3 rounded-[8px] flex items-center space-x-3 shadow-none"
                    >
                        <div class="w-9 h-9 bg-neutral-900 rounded-[6px] flex items-center justify-center text-white border border-[#262626]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-white tracking-wide">Siswa RPL</p>
                            <p class="text-[10px] text-[#737373] font-medium">{{ props.profile?.school }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section
                id="about"
                v-motion
                :initial="{ opacity: 0, y: 20 }"
                :visible-once="{ opacity: 1, y: 0, transition: { duration: 700, ease: EASE } }"
                class="space-y-8"
            >
                <div class="max-w-2xl">
                    <p class="text-xs font-bold text-[#A3A3A3] uppercase tracking-widest mb-2">Tentang Saya</p>
                    <p class="text-[15px] sm:text-[16px] text-[#A3A3A3] leading-relaxed">
                        {{ props.profile?.summary }}
                    </p>
                </div>

                <div
                    class="rounded-[12px] p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 divide-y sm:divide-y-0 lg:divide-x divide-[#262626]"
                >
                    <div
                        v-motion
                        :initial="{ opacity: 0, y: 24 }"
                        :visible-once="{ opacity: 1, y: 0, transition: { duration: 600, delay: 0, ease: EASE } }"
                        class="flex items-center space-x-4 pt-4 sm:pt-0 first:pt-0 lg:px-4"
                    >
                        <div class="w-11 h-11 bg-neutral-900 rounded-[8px] flex items-center justify-center text-[#A3A3A3] border border-[#262626]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#737373] font-bold uppercase tracking-wider">Nama</p>
                            <p class="text-[14px] text-white font-medium tracking-wide">{{ props.profile?.name }}</p>
                        </div>
                    </div>
                    <div
                        v-motion
                        :initial="{ opacity: 0, y: 24 }"
                        :visible-once="{ opacity: 1, y: 0, transition: { duration: 600, delay: 100, ease: EASE } }"
                        class="flex items-center space-x-4 pt-4 sm:pt-0 lg:px-4"
                    >
                        <div class="w-11 h-11 bg-neutral-900 rounded-[8px] flex items-center justify-center text-[#A3A3A3] border border-[#262626]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21V10.5m0 0L7.5 12m4.5-1.5l4.5 1.5M4.5 10.5v9a1.5 1.5 0 001.5 1.5h12a1.5 1.5 0 001.5-1.5v-9M12 3l8 4.5L12 12 4 7.5 12 3z" /></svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#737373] font-bold uppercase tracking-wider">Sekolah</p>
                            <p class="text-[14px] text-white font-medium tracking-wide">{{ props.profile?.school }}</p>
                        </div>
                    </div>
                    <div
                        v-motion
                        :initial="{ opacity: 0, y: 24 }"
                        :visible-once="{ opacity: 1, y: 0, transition: { duration: 600, delay: 200, ease: EASE } }"
                        class="flex items-center space-x-4 pt-4 lg:pt-0 lg:px-4"
                    >
                        <div class="w-11 h-11 bg-neutral-900 rounded-[8px] flex items-center justify-center text-[#A3A3A3] border border-[#262626]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.6 18.4V14.15m16.65 0c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125m16.65 0v-4.25c0-.621-.504-1.125-1.125-1.125H4.875c-.621 0-1.125.504-1.125 1.125m16.65 0V6a2.25 2.25 0 0 0-2.25-2.25H4.5A2.25 2.25 0 0 0 2.25 6v3.9" /></svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#737373] font-bold uppercase tracking-wider">Jurusan</p>
                            <p class="text-[14px] text-white font-medium tracking-wide">{{ props.profile?.major }}</p>
                        </div>
                    </div>
                    <div
                        v-motion
                        :initial="{ opacity: 0, y: 24 }"
                        :visible-once="{ opacity: 1, y: 0, transition: { duration: 600, delay: 300, ease: EASE } }"
                        class="flex items-center space-x-4 pt-4 lg:pt-0 lg:px-4"
                    >
                        <div class="w-11 h-11 bg-neutral-900 rounded-[8px] flex items-center justify-center text-[#A3A3A3] border border-[#262626]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#737373] font-bold uppercase tracking-wider">Lokasi</p>
                            <p class="text-[14px] text-white font-medium tracking-wide">{{ props.profile?.location }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section
                id="education"
                v-motion
                :initial="{ opacity: 0, y: 20 }"
                :visible-once="{ opacity: 1, y: 0, transition: { duration: 700, ease: EASE } }"
                class="space-y-10"
            >
                <div>
                    <p class="text-xs font-bold text-[#A3A3A3] uppercase tracking-widest mb-1">Riwayat</p>
                    <h2 class="text-[28px] font-bold tracking-tight text-white">Pendidikan</h2>
                </div>

                <div class="relative pl-8 space-y-10 before:content-[''] before:absolute before:left-[5px] before:top-2 before:bottom-2 before:w-px before:bg-[#262626]">
                    <div
                        v-for="(edu, i) in props.educations"
                        :key="edu.school"
                        v-motion
                        :initial="{ opacity: 0, x: -16 }"
                        :visible-once="{ opacity: 1, x: 0, transition: { duration: 550, delay: i * 120, ease: EASE } }"
                        class="relative"
                    >
                        <span class="absolute -left-8 top-1.5 flex w-[11px] h-[11px]">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#a3e635] opacity-40"></span>
                            <span class="relative inline-flex w-[11px] h-[11px] rounded-full bg-white border-2 border-[#090909] ring-1 ring-[#404040]"></span>
                        </span>
                        <p class="text-[11px] font-bold text-[#737373] uppercase tracking-wider mb-1">{{ edu.period }}</p>
                        <h3 class="text-[17px] font-bold text-white tracking-wide">{{ edu.school }}</h3>
                        <p v-if="edu.major" class="text-[13.5px] text-[#A3A3A3] mt-0.5">{{ edu.major }}</p>
                    </div>
                </div>
            </section>

            <section
                id="skills"
                v-motion
                :initial="{ opacity: 0, y: 20 }"
                :visible-once="{ opacity: 1, y: 0, transition: { duration: 700, ease: EASE } }"
                class="relative overflow-hidden py-20 px-6"
            >
                <div class="relative z-10 max-w-2xl mx-auto text-center space-y-4 mb-14">
                    <h2 class="text-[36px] sm:text-[44px] font-bold tracking-tight text-white">Keahlian</h2>
                    <div class="w-10 h-[2px] bg-[#a3e635] mx-auto"></div>
                    <p class="text-[14px] sm:text-[15px] text-[#A3A3A3] leading-relaxed">
                        Tools dan teknologi yang saya pakai untuk membangun aplikasi web modern.
                    </p>
                </div>

                <div class="relative z-10 space-y-6">
                    <div class="marquee-row">
                        <div class="marquee-track">
                            <div
                                v-for="(tech, i) in [...props.techFrontend, ...props.techFrontend]"
                                :key="'r1-' + i"
                                class="tech-icon-static"
                                :style="{ '--tech-color': tech.color }"
                                :title="tech.name"
                            >
                                <img
                                    v-if="tech.icon_key"
                                    :src="techIconUrl(tech)"
                                    :alt="tech.name"
                                    class="w-14 h-14 sm:w-16 sm:h-16"
                                    loading="eager"
                                    @error="handleIconError"
                                />
                                <span
                                    class="tech-fallback w-14 h-14 sm:w-16 sm:h-16 items-center justify-center text-[13px] font-bold tracking-wider rounded-full border border-[#262626]"
                                    :style="tech.icon_key ? 'display:none' : 'display:flex'"
                                >
                                    {{ tech.name.slice(0, 2).toUpperCase() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="marquee-row">
                        <div class="marquee-track marquee-track-reverse">
                            <div
                                v-for="(tech, i) in [...props.techBackend, ...props.techBackend]"
                                :key="'r2-' + i"
                                class="tech-icon-static"
                                :style="{ '--tech-color': tech.color }"
                                :title="tech.name"
                            >
                                <img
                                    v-if="tech.icon_key"
                                    :src="techIconUrl(tech)"
                                    :alt="tech.name"
                                    class="w-14 h-14 sm:w-16 sm:h-16"
                                    loading="eager"
                                    @error="handleIconError"
                                />
                                <span
                                    class="tech-fallback w-14 h-14 sm:w-16 sm:h-16 items-center justify-center text-[13px] font-bold tracking-wider rounded-full border border-[#262626]"
                                    :style="tech.icon_key ? 'display:none' : 'display:flex'"
                                >
                                    {{ tech.name.slice(0, 2).toUpperCase() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="projects" class="space-y-8">
                <div
                    v-motion
                    :initial="{ opacity: 0, y: 20 }"
                    :visible-once="{ opacity: 1, y: 0, transition: { duration: 600, ease: EASE } }"
                    class="flex items-end justify-between border-b border-[#262626] pb-4"
                >
                    <div>
                        <p class="text-xs font-bold text-[#A3A3A3] uppercase tracking-widest">Proyek Terpilih</p>
                        <h2 class="text-[28px] font-bold tracking-tight text-white mt-1">Beberapa Proyek Terbaik Saya</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                    <div
                        v-for="(project, i) in props.projects"
                        :key="project.title"
                        v-motion
                        @mousemove="handleSpotlight"
                        :initial="{ opacity: 0, y: 40 }"
                        :visible-once="{ opacity: 1, y: 0, transition: { duration: 650, delay: 100 + i * 150, ease: EASE } }"
                        :hovered="{ scale: 1.02, y: -6, boxShadow: '0 18px 38px -12px rgba(0,0,0,0.55), 0 0 0 1px rgba(163,230,21,0.25)', transition: { duration: 300, ease: EASE } }"
                        class="spotlight-card rounded-[12px] overflow-hidden group transition-colors duration-200 flex flex-col h-full will-change-transform"
                    >
                        <div class="relative z-[1] aspect-[43/20] w-full overflow-hidden bg-neutral-950 border-b border-[#262626]">
                            <img
                                v-if="project.image"
                                :src="`/storage/${project.image}`"
                                :alt="`Tampilan proyek ${project.title}`"
                                class="w-full h-full object-contain transition-transform duration-500 ease-out group-hover:scale-[1.02]"
                                loading="lazy"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center text-[#404040]">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 5.25h16.5v10.5a1.5 1.5 0 01-1.5 1.5h-13.5a1.5 1.5 0 01-1.5-1.5V5.25zM8.25 20.25h7.5M12 17.25v3" /></svg>
                            </div>
                        </div>

                        <div class="relative z-[1] flex flex-col flex-1 p-7">
                        <h3 class="text-[19px] font-bold tracking-wide text-white mb-2">{{ project.title }}</h3>
                        <p class="text-[14px] text-[#A3A3A3] leading-relaxed mb-5">{{ project.description }}</p>

                        <div class="flex flex-wrap gap-1.5 mb-6">
                            <span v-for="tech in project.tags" :key="tech" class="text-[10px] font-medium tracking-wider uppercase text-[#A3A3A3] bg-neutral-900 border border-[#262626] px-2.5 py-0.5 rounded-[4px]">
                                {{ tech }}
                            </span>
                        </div>

                        <div class="mt-auto pt-5 border-t border-[#262626]">
                            <p class="text-[10px] font-bold text-[#737373] uppercase tracking-wider mb-2">Fitur Utama</p>
                            <ul class="space-y-1.5">
                                <li v-for="feature in project.features" :key="feature" class="flex items-center text-[13.5px] text-[#A3A3A3]">
                                    <span class="w-1 h-1 rounded-full bg-[#525252] mr-2.5 flex-shrink-0"></span>
                                    {{ feature }}
                                </li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="soft-skills" class="space-y-8">
                <div
                    v-motion
                    :initial="{ opacity: 0, y: 20 }"
                    :visible-once="{ opacity: 1, y: 0, transition: { duration: 600, ease: EASE } }"
                >
                    <p class="text-xs font-bold text-[#A3A3A3] uppercase tracking-widest">Soft Skills</p>
                    <h2 class="text-[28px] font-bold tracking-tight text-white mt-1">Keahlian Dasar</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div
                        v-for="(skill, i) in props.softSkills"
                        :key="skill.title"
                        v-motion
                        @mousemove="handleSpotlight"
                        :initial="{ opacity: 0, y: 30 }"
                        :visible-once="{ opacity: 1, y: 0, transition: { duration: 600, delay: i * 120, ease: EASE } }"
                        :hovered="{ y: -4, boxShadow: '0 0 0 1px rgba(163,230,21,0.25)', transition: { duration: 250, ease: EASE } }"
                        class="spotlight-card group relative overflow-hidden rounded-[12px] p-6 transition-colors duration-200"
                    >
                        <div class="relative z-[1] w-10 h-10 bg-neutral-900 rounded-[8px] flex items-center justify-center text-white border border-[#262626] mb-4 transition-transform duration-300 ease-out group-hover:scale-110 group-hover:-rotate-6 group-hover:border-[#a3e635]/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="relative z-[1] text-[15px] font-bold text-white tracking-wide mb-1.5">{{ skill.title }}</h3>
                        <p class="text-[13px] text-[#A3A3A3] leading-relaxed">{{ skill.description }}</p>
                    </div>
                </div>
            </section>

            <section
                id="contact"
                v-motion
                :initial="{ opacity: 0, y: 24 }"
                :visible-once="{ opacity: 1, y: 0, transition: { duration: 700, ease: EASE } }"
                class="rounded-[12px] p-8 md:p-10 space-y-8"
            >
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left space-y-4 sm:space-y-0 sm:space-x-5">
                    <div class="w-14 h-14 bg-neutral-900 rounded-full flex items-center justify-center text-white border border-[#262626] flex-shrink-0 overflow-hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-[20px] font-bold tracking-wide text-white">Tertarik bekerja sama?</h3>
                        <p class="text-[13.5px] text-[#A3A3A3] max-w-md leading-relaxed">Saya selalu terbuka untuk peluang baru, magang, dan pengembangan proyek menarik.</p>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-4 pt-2 text-[12.5px] text-[#737373]">
                            <span>{{ props.profile?.phone }}</span>
                            <span class="hidden sm:inline text-[#404040]">•</span>
                            <span>{{ props.profile?.location }}</span>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submitContact" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
                    <!-- Honeypot anti-spam, disembunyikan dari user asli -->
                    <input
                        v-model="contactForm.website"
                        type="text"
                        name="website"
                        tabindex="-1"
                        autocomplete="off"
                        class="hidden"
                        aria-hidden="true"
                    />

                    <div class="space-y-1.5">
                        <label for="contact-name" class="text-[11px] font-bold text-[#737373] uppercase tracking-wider">Nama</label>
                        <input
                            id="contact-name"
                            v-model="contactForm.name"
                            type="text"
                            placeholder="Nama kamu"
                            class="w-full h-[44px] px-4 bg-[#0d0d0d] border border-[#262626] focus:border-[#a3e635] rounded-[8px] text-[14px] text-white placeholder-[#525252] outline-none transition-colors duration-200"
                        />
                        <p v-if="contactForm.errors.name" class="text-[12px] text-red-400">{{ contactForm.errors.name }}</p>
                    </div>

                    <div class="space-y-1.5">
                        <label for="contact-email" class="text-[11px] font-bold text-[#737373] uppercase tracking-wider">Email</label>
                        <input
                            id="contact-email"
                            v-model="contactForm.email"
                            type="email"
                            placeholder="email@kamu.com"
                            class="w-full h-[44px] px-4 bg-[#0d0d0d] border border-[#262626] focus:border-[#a3e635] rounded-[8px] text-[14px] text-white placeholder-[#525252] outline-none transition-colors duration-200"
                        />
                        <p v-if="contactForm.errors.email" class="text-[12px] text-red-400">{{ contactForm.errors.email }}</p>
                    </div>

                    <div class="sm:col-span-2 space-y-1.5">
                        <label for="contact-message" class="text-[11px] font-bold text-[#737373] uppercase tracking-wider">Pesan</label>
                        <textarea
                            id="contact-message"
                            v-model="contactForm.message"
                            rows="4"
                            placeholder="Tulis pesan kamu di sini..."
                            class="w-full px-4 py-3 bg-[#0d0d0d] border border-[#262626] focus:border-[#a3e635] rounded-[8px] text-[14px] text-white placeholder-[#525252] outline-none resize-none transition-colors duration-200"
                        ></textarea>
                        <p v-if="contactForm.errors.message" class="text-[12px] text-red-400">{{ contactForm.errors.message }}</p>
                    </div>

                    <div class="sm:col-span-2 flex items-center gap-4 pt-1">
                        <button
                            type="submit"
                            :disabled="contactForm.processing"
                            class="btn-sweep btn-sweep-primary inline-flex items-center justify-center h-[46px] px-6 text-[13.5px] font-medium tracking-wide rounded-[8px] disabled:opacity-60 disabled:cursor-not-allowed"
                        >
                            <svg v-if="!contactForm.processing" class="w-4 h-4 mr-2 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                            <span>{{ contactForm.processing ? 'Mengirim...' : 'Kirim Pesan' }}</span>
                        </button>

                        <Transition name="fade-scale">
                            <p v-if="contactSuccess" class="text-[13px] text-[#a3e635] font-medium">
                                Pesan berhasil terkirim! Saya akan segera membalas.
                            </p>
                        </Transition>
                    </div>
                </form>
            </section>
        </main>

        <footer class="border-t border-[#262626] bg-[#090909]/90 backdrop-blur-sm mt-32">
            <div class="max-w-[1320px] mx-auto px-6 lg:px-[42px] h-[80px] flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-[20px] font-bold tracking-tight text-white select-none">
                    DA<span class="text-[#737373]">.</span>
                </div>

                <p class="text-[12px] text-[#737373] font-medium tracking-wide">
                    &copy; 2026 {{ props.profile?.name }}. Hak cipta dilindungi.
                </p>

                <div class="flex items-center space-x-5">
                    <a :href="socialUrl('github')" target="_blank" rel="noopener" class="flex items-center gap-2 text-[#737373] hover:text-white transition-colors duration-200">
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0 0 22 12.017C22 6.484 17.522 2 12 2Z" clip-rule="evenodd" /></svg>
                        <span class="text-[13px] font-medium tracking-wide">Terhubung</span>
                    </a>
                </div>
            </div>
        </footer>

        <Transition name="fade-scale">
            <button
                v-if="showBackToTop"
                type="button"
                @click="scrollToTop"
                class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-[#111111] border border-[#262626] hover:border-[#a3e635] text-white flex items-center justify-center shadow-lg transition-colors duration-200"
                aria-label="Kembali ke atas"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 15.75l7.5-7.5 7.5 7.5" /></svg>
            </button>
        </Transition>

        </div>

    </div>
</template>

<style scoped>
.btn-sweep {
    position: relative;
    isolation: isolate;
    overflow: hidden;
    transition: color 0.35s cubic-bezier(0.22, 1, 0.36, 1), transform 0.15s ease;
}

.btn-sweep::before {
    content: '';
    position: absolute;
    inset: 0;
    z-index: -1;
    transform: translateX(-100%);
    transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}

.btn-sweep:hover::before {
    transform: translateX(0%);
}

.btn-sweep::after {
    content: '';
    position: absolute;
    top: 0;
    left: -75%;
    width: 40%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.55), transparent);
    transform: skewX(-20deg);
    z-index: 2;
    pointer-events: none;
    transition: left 0.65s ease;
}

.btn-sweep:hover::after {
    left: 135%;
}

.btn-sweep:active {
    transform: scale(0.96);
}

.btn-sweep span,
.btn-sweep svg {
    position: relative;
    z-index: 1;
}

.btn-sweep-primary {
    background-color: #fff;
    color: #000;
}
.btn-sweep-primary::before {
    background-color: #a3e635;
}

.btn-sweep-outline {
    background-color: transparent;
    border: 1px solid #fff;
    color: #fff;
}
.btn-sweep-outline::before {
    background-color: #fff;
}
.btn-sweep-outline:hover {
    color: #000;
}

.spotlight-card {
    position: relative;
}

.spotlight-card::before {
    content: '';
    position: absolute;
    inset: 0;
    z-index: -1;
    background: radial-gradient(
        480px circle at var(--mouse-x, 50%) var(--mouse-y, 50%),
        rgba(163, 230, 21, 0.12),
        transparent 45%
    );
    opacity: 0;
    transition: opacity 0.35s ease;
    pointer-events: none;
}

.spotlight-card:hover::before {
    opacity: 1;
}

/* === Efek foto profil: reveal warna + glow border saat hover === */
.photo-reveal {
    filter: grayscale(1) brightness(0.9) contrast(1.05);
    transition: filter 0.6s cubic-bezier(0.22, 1, 0.36, 1), transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
}

.group:hover .photo-reveal {
    filter: grayscale(0) brightness(1) contrast(1);
    transform: scale(1.03);
}

.photo-glow {
    position: relative;
    transition: border-color 0.4s ease;
}

.photo-glow::before {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: 12px;
    padding: 1px;
    background: linear-gradient(135deg, rgba(163, 230, 21, 0.5), transparent 60%);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
    z-index: 2;
}

.photo-glow:hover::before {
    opacity: 1;
}

.photo-glow:hover {
    border-color: #a3e635;
}

.marquee-row {
    overflow-x: hidden;
    overflow-y: visible;
    -webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
    mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
    padding-block: 1.5rem;
}

.marquee-track {
    display: flex;
    width: max-content;
    gap: 2.25rem;
    align-items: center;
    animation: marquee-scroll 38s linear infinite;
    will-change: transform;
    backface-visibility: hidden;
}

.marquee-track-reverse {
    animation-direction: reverse;
    animation-duration: 42s;
}

.marquee-row:hover .marquee-track {
    animation-play-state: paused;
}

@keyframes marquee-scroll {
    from {
        transform: translate3d(0, 0, 0);
    }
    to {
        transform: translate3d(-50%, 0, 0);
    }
}

.tech-icon-static {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    cursor: default;
}

.tech-icon-static img,
.tech-icon-static span {
    transition: filter 0.3s ease, opacity 0.3s ease, color 0.3s ease, border-color 0.3s ease, transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
}

.tech-icon-static img {
    filter: grayscale(1) brightness(0.65);
    opacity: 0.75;
}

.tech-fallback {
    color: #6b7280;
    opacity: 0.9;
    background: #111111;
}

.tech-icon-static:hover img {
    filter: grayscale(0) brightness(1);
    opacity: 1;
    transform: scale(1.18) rotate(-6deg);
}

.tech-icon-static:hover .tech-fallback {
    color: var(--tech-color);
    border-color: var(--tech-color);
    opacity: 1;
    transform: scale(1.1);
}

@media (prefers-reduced-motion: reduce) {
    .marquee-track {
        animation: none;
    }
    .spotlight-card::before,
    .btn-sweep::after,
    .photo-reveal,
    .photo-glow::before,
    .tech-icon-static img,
    .tech-icon-static span,
    .hamburger-bar,
    .nav-underline {
        transition: none !important;
    }
    .btn-sweep:active {
        transform: none;
    }
    .animate-ping {
        animation: none !important;
    }
}

.mobile-menu-enter-active,
.mobile-menu-leave-active {
    transition: max-height 0.3s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.25s ease;
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
    max-height: 0;
    opacity: 0;
}

.mobile-menu-enter-to,
.mobile-menu-leave-from {
    max-height: 480px;
    opacity: 1;
}

.nav-link {
    overflow: hidden;
}

.nav-underline {
    position: absolute;
    left: 16px;
    right: 16px;
    bottom: 6px;
    height: 1px;
    background: currentColor;
    transform: scaleX(0);
    transform-origin: center;
    transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    pointer-events: none;
}

.nav-link:hover .nav-underline {
    transform: scaleX(1);
}

.hamburger {
    position: relative;
    display: inline-block;
    width: 20px;
    height: 16px;
}

.hamburger-bar {
    position: absolute;
    left: 0;
    width: 100%;
    height: 1.75px;
    border-radius: 2px;
    background: currentColor;
    transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.25s ease, top 0.3s cubic-bezier(0.22, 1, 0.36, 1);
}

.hamburger-bar:nth-child(1) { top: 0; }
.hamburger-bar:nth-child(2) { top: 7px; }
.hamburger-bar:nth-child(3) { top: 14px; }

.hamburger.is-open .hamburger-bar:nth-child(1) {
    top: 7px;
    transform: rotate(45deg);
}
.hamburger.is-open .hamburger-bar:nth-child(2) {
    opacity: 0;
}
.hamburger.is-open .hamburger-bar:nth-child(3) {
    top: 7px;
    transform: rotate(-45deg);
}

.fade-scale-enter-active,
.fade-scale-leave-active {
    transition: opacity 0.25s ease, transform 0.25s ease;
}

.fade-scale-enter-from,
.fade-scale-leave-to {
    opacity: 0;
    transform: scale(0.85) translateY(8px);
}
</style>
