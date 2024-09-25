<template>

    <MenuBar />
    <Banner />
    <Contact />


    <Footer />

</template>

<script>
import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
import Banner from '@//Pages/Home/Contact/Banner.vue';
import Contact from '@//Pages/Home/Contact/Contact.vue';
import Footer from '@/Components/Organisims/Home/Footer.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted } from 'vue';

export default {

    components: {
        MenuBar,
        Banner,
        Contact,
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
