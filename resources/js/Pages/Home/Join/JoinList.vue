<template>

    <MenuBar/>
    <Banner/>
    <Form/>


    <Footer />

    </template>

    <script>
    import MenuBar from '@/Components/Organisims/Home/MenuBar.vue';
    import Banner from '@//Pages/Home/Join/Banner.vue';
    import Form from '@//Pages/Home/Join/Form.vue';
    import Footer from '@/Components/Organisims/Home/Footer.vue';
    export default {

        components: {
            MenuBar,
            Banner,
            Form,
            Footer,
        },

        setup () {

        }
    }

    </script>
