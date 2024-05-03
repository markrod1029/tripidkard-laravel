<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container mt-5">
                <div class="bg-white p-4 rounded shadow text-center mx-auto custom-container">
                    <img class="img-fluid mx-auto"
                        src="https://tripidkard.com/wp-content/uploads/2023/10/tripid-card-ver.-2-1.png" width="150"
                        height="100" />
                    <h3>Total of Loyalty Stars</h3>
                    <form method="PUT" @submit.prevent="createStars">

                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input class="form-control" v-for="star in stars" :key="star.id"
                                    :value="star.stars + ' ' + star.newProperty" readonly>
                                <input class="form-control" v-model="form.id" hidden>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">

                                <input type="number" class="form-control" id="stars" name="stars"
                                    placeholder="Total Stars" v-model="form.stars">
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <button type="submit" name="save" class="btn btn-primary px-5 ">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <Footer />
</template>
<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import axios from 'axios';

import { useRouter } from 'vue-router';
import { useToastr } from '@/toastr';

const stars = ref([]);
const router = useRouter();
const toastr = useToastr();

const form = reactive({
    id:'',
    stars:''
});

const getStars = async () => {
    try {
        const response = await axios.get('/api/stars');
        const modifiedStars = response.data.map(star => {
            return {
                ...star,
                newProperty: 'Star Points',
            };
        });
        stars.value = modifiedStars;
        form.id = stars.value[0].id; // Set the form id to the first star id
    } catch (error) {
        console.error('Error fetching stars:', error);
    }
}

watch(() => stars.value, async (newValue) => {
    form.id = newValue[0].id;
});

const createStars = async () => {
    try {
        const response = await axios.put('/api/stars/update', form);
        router.push('/admin/loyalty-stars');
        toastr.success(response.data.message);
    } catch (error) {
        console.error('Error creating stars:', error);
        if (error.response && error.response.status === 422) {
            toastr.error(error.response.data.message);
        } else {
            toastr.error('An error occurred while updating stars');
        }
    }
}

onMounted(() => {
    getStars();
})
</script>
