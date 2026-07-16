import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { MotionPlugin } from '@vueuse/motion';

createInertiaApp({
    /* |--------------------------------------------------------------------------
    | Dynamic Page Title Layout
    |--------------------------------------------------------------------------
    | Mengatur judul tab browser secara otomatis. Jika halaman memberikan title,
    | formatnya menjadi "Nama Halaman — Portfolio". Jika tidak, memakai fallback.
    */
    title: (title) => title ? `${title} — Portfolio` : 'Destria Angelyne — Personal Portfolio',

    /* |--------------------------------------------------------------------------
    | Code Splitting & Page Resolution
    |--------------------------------------------------------------------------
    | Menggunakan Vite glob import untuk memetakan string nama page dari controller
    | (misal: Inertia::render('Home')) ke file Vue fisik di folder Pages.
    */
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },

    /* |--------------------------------------------------------------------------
    | Application Bootstrapping
    |--------------------------------------------------------------------------
    | Membuat instance aplikasi Vue 3, menyuntikkan plugin Inertia & Motion V,
    | lalu memasang (mount) aplikasi ke elemen HTML dengan id="app" di app.blade.php.
    */
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(MotionPlugin, { reducedMotion: 'user' }) // Animasi global v-motion, hormati setting "Reduce Motion" OS
            .mount(el);
    },

    /* |--------------------------------------------------------------------------
    | Elegant Loading Progress Indicator
    |--------------------------------------------------------------------------
    | Menampilkan loading bar tipis di bagian atas layar saat transisi halaman.
    | Menggunakan warna Indigo (#6366f1) untuk estetika premium.
    */
    progress: {
        color: '#6366f1',
        showSpinner: false, // Menghilangkan spinner berputar agar tetap minimalis
    },
});
