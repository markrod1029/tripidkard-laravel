<template>

    <MenuBar />
    <Banner />


    <Information />
    <Footer />

</template>

<script>
import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
import Banner from '@//Pages/Home/ScannerResult/Banner.vue';
import Information from '@//Pages/Home/ScannerResult/Information.vue';
import Footer from '@/Components/Organisims/Home/Footer.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted } from 'vue';

export default {

    components: {
        MenuBar,
        Banner,
        Information,
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
