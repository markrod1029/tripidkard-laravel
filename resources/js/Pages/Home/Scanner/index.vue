<template>

    <MenuBar/>
    <Banner/>

    <Scanner/>

    <Footer />

    </template>

    <script>
    import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
    import Banner from '@//Pages/Home/Scanner/Banner.vue';
    import Scanner from '@//Pages/Home/Scanner/Scanner.vue';
    import Footer from '@/Components/Organisims/Home/Footer.vue';
    export default {

        components: {
            MenuBar,
            Banner,
            Scanner,
            Footer,
        },

        setup () {

        }
    }

    </script>
