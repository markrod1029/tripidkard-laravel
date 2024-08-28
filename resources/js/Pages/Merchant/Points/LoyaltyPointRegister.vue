<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container mt-5">
                <div class="bg-white p-4 rounded shadow text-center mx-auto  custom-container w-75 mt-5 ">

                    <img class="img-fluid mx-auto"
                        src="https://tripidkard.com/wp-content/uploads/2023/10/tripid-card-ver.-2-1.png" width="150"
                        height="100" />
                    <h3 v-if="editPointsTitle">Register Loyalty Stars</h3>
                    <h3 v-else>Update Loyalty Stars</h3>
                    <form method="POST" @submit.prevent="handdleSubmit">

                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input type="text" v-model="form.card_number" class="form-control" id="card_number"
                                    name="card_number" placeholder="Card Number" value="" :readonly="editMode" required>
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>


                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input type="text" v-model="form.price" class="form-control" id="price" name="price"
                                    placeholder="Total Price" value="" :readonly="editMode" required>
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="col-md-12 d-flex align-items-center">
                                <input type="text" class="form-control" id="loyalty_points" name="points"
                                    v-model="form.points" placeholder="Total Loyalty Points" value="" required>
                                <span class="ml-2 text-danger">*</span>
                            </div>
                        </div>

                        <button type="submit" name="" class="custom-button btn btn-primary btn-block ">Submit</button>
                    </form>

                </div>
            </div>
        </section>

    </div>

    <Footer />
</template>

<script>
import axios from 'axios';
import { ref, reactive, onMounted } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useRouter, useRoute } from 'vue-router';
import { useToastr } from '@/toastr.js';

export default {
    components: {
        MenuBar,
        Sidebar,
        Footer,
        Breadcrumb
    },
    setup() {
        const router = useRouter();
        const toastr = useToastr();
        const route = useRoute();

        const form = reactive({
            card_number: '',
            product_price: '',
            points: ''
        });

        const errorMessage = ref('');
        const editPointsTitle = ref(false);
        const editMode = ref(false);

        const createPoints = async () => {
            try {
                const response = await axios.post('/api/merchant/points/register', form);
                router.push('/merchant/loyalty-stars');
                toastr.success(response.data.message); // I-update ang error na ito
            } catch (error) {
                console.error('Error creating stars:', error);
                if (error.response && error.response.status === 422) {
                    toastr.error(error.response.data.message);
                } else {
                    toastr.error('An error occurred while Adding stars');
                }
            }
        }

        const getPoints = async () => {
            try {
                const response = await axios.get(`/api/merchant/points/${route.params.id}/edit`);
                const data = response.data;
                form.card_number = data.card_number;
                form.price = data.product_price;
                form.points = data.points;
                editMode.value = true;
            } catch (error) {
                errorMessage.value = error.response.data.error;
                toastr.error(errorMessage.value);
            }
        }

        const updatePoints = async () => {
            try {
                await axios.post(`/api/merchant/points/${route.params.id}/edit`, form);
                router.push('/merchant/loyalty-stars');
                toastr.success('Points Updated Successfuly');
            } catch (error) {
                errorMessage.value = error.response.data.error;
                toastr.error(errorMessage.value);
            }
        }

        const handdleSubmit = async () => {
            if (editPointsTitle.value) {
                await updatePoints();
            } else {
                await createPoints();
            }
        }

        onMounted(() => {
            if (route.name === 'merchant.loyalty-points.edit') {
                editPointsTitle.value = true;
                getPoints();
            }
        });

        return {
            form,
            handdleSubmit,
            editPointsTitle,
            editMode
        };
    }
}
</script>



<style scoped>
.custom-button {
    font-size: 1.2rem; /* Adjusts the font size */
    max-width: 200px; /* Sets a maximum width for the button */
    margin: 1rem auto 0; /* Centers the button and adds margin */
}
</style>
