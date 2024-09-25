<template>
    <MenuBar />
    <Banner />
    <Search />
    <Raffle />
    <Footer />
</template>

<script>
import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
import Banner from '@//Pages/Home/Dashboard/Banner.vue';
import Search from '@/Components/Molecules/Search/ProvinceSearch.vue';

import Raffle from '@//Pages/Home/Dashboard/Raffle.vue';
import Footer from '@/Components/Organisims/Home/Footer.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted } from 'vue';

export default {
    components: {
        MenuBar,
        Search,
        Banner,
        Raffle,
        Footer,
    },

    setup() {
        const authStore = useAuthStore();
        onMounted(async() => {
            await authStore.getUser();
        });
    },
}
</script>
