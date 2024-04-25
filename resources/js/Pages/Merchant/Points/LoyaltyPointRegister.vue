<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />


        <section class="content">

            <div class="container mt-5">
                <div class="bg-white p-4 rounded shadow text-center mx-auto  custom-container">

                    <img class="img-fluid mx-auto"
                        src="https://tripidkard.com/wp-content/uploads/2023/10/tripid-card-ver.-2-1.png" width="150"
                        height="100" />
                            <h3 v-if="editPointsTitle">Register Loyalty Stars</h3>
                            <h3 v-else>Update Loyalty Stars</h3>
                            <form method="POST" @submit.prevent="handdleSubmit">

                                <div class="form-group mt-3">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <input type="text" v-model="form.card_number" class="form-control" id="card_number" name="card_number"
                                            placeholder="Card Number"
                                            value=""
                                            :readonly="editMode"
                                            required>
                                        <span class="ml-2 text-danger">*</span>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <input type="text" class="form-control" v-model="form.product_code" id="product_code" name="product_code"
                                            value=""
                                             placeholder="Product Code" 
                                            :readonly="editMode"
                                             required>
                                        <span class="ml-2 text-danger">*</span>
                                    </div>
                                </div>


                                <div class="form-group mt-3">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <input type="text" v-model="form.price" class="form-control" id="price" name="price"
                                            placeholder="Total Price"
                                            value=""
                                            :readonly="editMode"
                                             required>
                                        <span class="ml-2 text-danger">*</span>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <div class="col-md-12 d-flex align-items-center">
                                        <input type="text" class="form-control" id="loyalty_points"
                                            name="points" v-model="form.points" placeholder="Total Loyalty Points"
                                            value=""
                                            required>
                                        <span class="ml-2 text-danger">*</span>
                                    </div>
                                </div>


                                <!-- <input type="text" class="form-control" id="loyalty_id" name="loyalty_id" -->
                                <!-- :value="authUser.users.id" v-model="form.user_id" placeholder="Merchant ID" hidden> -->
                                <button type="submit" name="" class="btn btn-primary">Submit</button>
                            </form>

                </div>
            </div>


        </section>



    </div>

    <Footer />
</template>

<script setup>
import axios from 'axios';
import { ref, reactive, onMounted } from 'vue';
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useRouter, useRoute } from 'vue-router';
import { useToastr } from '@/toastr.js';


const router = useRouter();
const toastr = useToastr();
const route = useRoute();

const form = reactive({
    card_number: '',
    product_code: '',
    product_price: '',
    points: ''
});

const points = ref([]);
const errorMessage = ref('');
const editPointsTitle = ref(false);
const editMode = ref(false);
let createPoints = async (values, actions) => {
    try {
        await axios.post('/api/merchant/points/register', form);
        router.push('/merchant/loyalty-points');
        toastr.success('Customer Updated Successfuly');

    } catch (error) {
        if (error.response) {
            errorMessage.value = errorMessage.valueage;
            toastr.success(errorMessage.value);
        } else {
            errorMessage.value = "An error occurred.";
        }
    }

}

let getPoints = async () => {
    try {
        const response  = await axios.get(`/api/merchant/points/${route.params.id}/edit`, form);
       const data = response.data;
        form.card_number = data.card_number;
        form.product_code = data.product_code;
        form.price = data.product_price;
        form.points = data.points;
        editMode.value = true;
    } catch (error) {
        if (actions && actions.setErrors) {
      actions.setErrors(error.response.data.errors);
  }
  error.value = error.response.data.error;
  console.log(error.response.data);
    }
}

let updatePoints = async () => {
    try {
        await axios.post(`/api/merchant/points/${route.params.id}/edit`, form);
    router.push('/merchant/loyalty-points');
    toastr.success('Points Updated Successfuly');
 
    }
    catch(error)  {
            if (actions && actions.setErrors) {
                actions.setErrors(error.response.data.errors);
            }
            error.value = error.response.data.error;
        }
}

let handdleSubmit = async (values, actions) => {

    if(editPointsTitle.value) {
        updatePoints(values, actions);
    } else {
        createPoints(values, actions);
    }

}

onMounted(() => {
    if(route.name === 'merchant.loyalty-points.edit'){
        editPointsTitle.value = true;
        getPoints();
    }
})

</script>
