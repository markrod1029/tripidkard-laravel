<template>

    <MenuBar />
    <Banner />
    <Details />
    <FAQ />

    <Footer />

</template>

<script>
import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
import Banner from '@//Pages/Home/Tripidkard/Banner.vue';
import Details from '@/Pages/Home/Tripidkard/Details.vue';
import FAQ from '@/Pages/Home/Tripidkard/FAQ.vue';
import Footer from '@/Components/Organisims/Home/Footer.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted } from 'vue';

export default {

    components: {
        MenuBar,
        Banner,
        FAQ,
        Details,
        Footer,
    },

    setup() {
        const authStore = useAuthStore();
        onMounted(async () => {
            await authStore.getUser();
        });
    }
}

</script>
