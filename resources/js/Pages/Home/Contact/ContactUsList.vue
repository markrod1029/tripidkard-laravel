<template>

    <MenuBar/>
    <Banner/>
    <Contact/>


    <Footer />

    </template>

    <script>
    import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
    import Banner from '@//Pages/Home/Contact/Banner.vue';
    import Contact from '@//Pages/Home/Contact/Contact.vue';
    import Footer from '@/Components/Organisims/Home/Footer.vue';
    export default {

        components: {
            MenuBar,
            Banner,
            Contact,
            Footer,
        },

        setup () {

        }
    }

    </script>
