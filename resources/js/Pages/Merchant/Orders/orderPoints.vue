<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container mt-5">
                <div class="bg-white p-4 rounded shadow text-center mx-auto custom-container">
                    <img class="img-fluid mx-auto"
                        src="https://scontent.fmnl17-6.fna.fbcdn.net/v/t39.30808-6/399434519_122118450656079042_7601433698559540672_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFganLRFe4as7VGZgSGFL4uCAaG5sSOyxIIBobmxI7LEpL9o-leIwHBfb0dSo2CXZiUCtiVG_p7pmpGcYIQ4OZx&_nc_ohc=ciZu2eLfLtEQ7kNvgFULvi-&_nc_ht=scontent.fmnl17-6.fna&_nc_gid=AmYW0fjwy3v3H-PJAlOVj5D&oh=00_AYDvnNWYNVKIzPTAMYFph7JeCjZIeVEyuXvVp1y_UoCU_g&oe=670D0EEC"
                        width="150" height="100" />
                    <h3 v-if="updatestarts">Update Merchant Loyalty Stars</h3>
                    <h3 v-else>Register Merchant Loyalty Stars</h3>
                    <form method="POST" @submit.prevent="handdleSubmit">


                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input class="form-control"  :value="(authUser.users.stars_points || 0) + ' Star Points'" readonly>
                                <input class="form-control" v-model="form.id" hidden>

                            </div>
                        </div>





                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <select v-if="!showOtherInput && updatestarts == false" class="form-control"
                                    name="starsPoints" v-model="form.starsPoints" id="starsPoints"
                                    @change="handleSelectChange">
                                    <option value="" disabled selected>Select Loyalty Stars</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input v-else type="number" class="form-control" id="loyalty_points"
                                    name="loyalty_points" placeholder="Total Loyalty Stars"
                                    v-model="form.otherStarsPoints" @blur="handleOtherInputBlur">
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
import { onMounted, reactive, ref } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import axios from 'axios';
import { useAuthUserStore } from '../../../Stores/AuthUser';

import { useRouter, useRoute } from 'vue-router';
import { useToastr } from '@/toastr';
const showOtherInput = ref(false);
const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const authUser = useAuthUserStore();

const stars = ref([]);

const updatestarts = ref(false);
const form = reactive({
    id: '',
    merchant: '',
    otherStarsPoints: ''
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




const handleSelectChange = () => {
    if (form.starsPoints === 'Other') {
        showOtherInput.value = true;
        form.starsPoints = null; // Reset starsPoints value
    } else {
        showOtherInput.value = false;
        form.otherStarsPoints = form.starsPoints; // Set otherStarsPoints equal to starsPoints
    }
}

const handleOtherInputBlur = () => {
    if (!form.otherStarsPoints.trim()) {
        form.starsPoints = null; // Reset starsPoints value if otherStarsPoints is empty
    }
}

const createStars = async () => {
    try {
        const response = await axios.post('/api/loyalty-stars/crete', form);
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


const getPoints = async () => {
    try {
        const response = await axios.get(`/api/loyalty-stars/${route.params.id}/edit`);
        const data = response.data;
        form.merchant = data.id;
        form.starsPoints = data.stars_points;
        form.otherStarsPoints = data.stars_points;
    } catch (error) {

    }
}


const updatePoints = async () => {
    try {
        const response = await axios.put(`/api/loyalty-stars/edit`, form);
        router.push('/admin/loyalty-stars');
        toastr.success(response.data.message);
    } catch (error) {

    }
}

const handdleSubmit = async () => {
    if (updatestarts.value) {
        await updatePoints();
    } else {
        await createStars();
    }
}

onMounted(() => {
    if (route.name === 'admin.loyalty-stars.edit') {
        updatestarts.value = true;
        getPoints();
        getStars();
    }
    getMerchants();
    getStars();

})
</script>
