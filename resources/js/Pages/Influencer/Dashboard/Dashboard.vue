<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">

        <Breadcrumb />


        <section class="container">

            <div class="row">

                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="far fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Merchant List</span>
                            <!-- <?php
                        $sql = "SELECT * FROM merchant LEFT JOIN business ON merchant.id = business.merchant_id WHERE business.status = '1'";
                        $query = $conn->query($sql);

                        ?>
                        <span class="info-box-number"><?php  echo $merchant_total = $query->num_rows; ?></span> -->
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="far fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Customer List</span>
                            <!-- <?php
                        $sql = "SELECT * FROM customer";
                        $query = $conn->query($sql);

                        ?>
                        <span class="info-box-number"><?php  echo $customer_total = $query->num_rows; ?></span> -->
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="far fa-coins"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tripidkard List </span>
                            <!-- <?php
                        $sql = "SELECT * FROM customer_code";
                        $query = $conn->query($sql);

                        ?> -->
                            <!-- <span class="info-box-number"><?php  echo $tripidkard_total = $query->num_rows; ?></span> -->
                        </div>
                    </div>
                </div>


            </div>


            <div class="container">

                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="100%" height="400" id="gmap_canvas"
                            :src="`https://maps.google.com/maps?q=${encodeURIComponent(userAddress)}&t=&z=15&ie=UTF8&iwloc=&output=embed`"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        <a href="https://putlocker-is.org"></a>
                        <br>
                    </div>
                </div>
            </div>



        </section>


    </div>
    <Footer />

</template>

<script>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { useAuthStore } from '@/Stores/auth';
import { onMounted } from 'vue';


export default {
    components: {
        MenuBar,
        Sidebar,
        Footer,
        Breadcrumb,
    },

    setup() {
        const authStore = useAuthStore();
        const userAddress = ref('');

        onMounted(async () => {
            await authStore.getUser();
            userAddress.value = authStore.user?.zip + ' ' + authStore.user?.street + ' ' + authStore.user?.city + ' ' + authStore.user?.province || 'Dagupan City Pangasinan';

        });
        return {
            userAddress,
        }

    },
}

</script>
