<template>

    <MenuBar/>
    <Banner/>
    <Details/>
    <h1>{{ $route.meta.title }}</h1>

    <Footer />

    </template>

    <script>
    import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
    import Banner from '@//Pages/Home/Tripidkard/Banner.vue';
    import Details from '@//Pages/Home/Tripidkard/Details.vue';
    import Footer from '@/Components/Organisims/Home/Footer.vue';
    export default {

        components: {
            MenuBar,
            Banner,
            Details,
            Footer,
        },

        setup () {

        }
    }

    </script>
