<template>

<MenuBar/>
<Banner/>
<Raffle/>
<Merchant/>
<h1>{{ $route.meta.title }}</h1>

<Footer />

</template>

<script>
import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
import Banner from '@//Pages/Home/Dashboard/Banner.vue';
import Raffle from '@//Pages/Home/Dashboard/Raffle.vue';
import Merchant from '@//Pages/Home/Dashboard/MerchantList.vue';
import Footer from '@/Components/Organisims/Home/Footer.vue';
export default {

    components: {
        MenuBar,
        Banner,
        Raffle,
        Merchant,
        Footer,
    },

    setup () {

    }
}

</script>
