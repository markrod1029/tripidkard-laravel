<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">

                <!-- Create Voucher Button  -->
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary create-voucher-btn ms-2" @click="createVoucher">
                        Create Voucher
                    </button>
                </div>

                <!-- Vouchers List in a Two-Column Layout -->
                <div class="card-body">
                    <div class="row">
                        <div v-for="voucher in vouchers" :key="voucher.code" class="col-md-6 mb-4">
                            <div class="voucher-card">
                                <div class="voucher-details">
                                    <h5 class="voucher-title">{{ voucher.code }}</h5>

                                    <!-- Description with Alert Icon -->
                                    <div class="voucher-description">
                                        <span class="alert-icon"></span>
                                        <span>{{ voucher.description }}</span>
                                    </div>

                                    <div class="voucher-date">
                                        <span>Expires on: {{ formatDate(voucher.expiry) }}</span>
                                    </div>

                                    <ul class="voucher-terms">
                                        <li v-for="term in voucher.terms" :key="term">{{ term }}</li>
                                    </ul>
                                </div>

                                <hr class="voucher-divider">

                                <!-- Code and Button Layout -->
                                <div class="voucher-footer">
                                    <div class="voucher-code">
                                        <span>{{ voucher.code }} </span>
                                    </div>
                                    <button class="btn btn-primary redeem-btn" @click="redeemVoucher(voucher.code)">
                                        Redeem Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <Footer class="custom-footer" />

    <Cart />
</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import Cart from '@/Pages/Merchant/Orders/cartIcon.vue';
import { reactive } from 'vue';
import { useToastr } from '@/toastr.js';
import axios from 'axios';

const formatDate = (date) => {
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
    return new Date(date).toLocaleDateString('en-US', options);
};

const vouchers = reactive([
    {
        title: 'Example',
        description: 'For food, pick-up, and groceries orders',
        expiry: '2024-11-15',
        terms: [
            'Varying minimum spend',
            'Limited redemptions available',
            'Cashback expires 96 hours after redemption'
        ],
        code: 'Code'
    },
    {
        title: 'Example',
        description: 'For food, pick-up, and groceries orders',
        expiry: '2024-11-15',
        terms: [
            'Varying minimum spend',
            'Limited redemptions available',
            'Cashback expires 96 hours after redemption'
        ],
        code: 'Code'
    },
]);

const toastr = useToastr();

const redeemVoucher = async (code) => {
    try {
        const response = await axios.post('/api/voucher/redeem', { code });
        toastr.success(response.data.message || `Voucher ${code} redeemed successfully`);
    } catch (error) {
        console.error(error);
        toastr.error(error.response?.data?.message || `Failed to redeem voucher ${code}`);
    }
};

// Create Voucher button click handler
const createVoucher = () => {
    console.log("Create Voucher button clicked");
};
</script>

<!-- Add Styles for Cart Icon in Footer -->
<style scoped>
.custom-footer {
  z-index: 1000;
}

.voucher-card {
    display: flex;
    flex-direction: column;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.voucher-card:hover {
    transform: translateY(-5px);
}

.voucher-title {
    font-size: 1.5em;
    font-weight: bold;
    color: #367FA9;
}

.voucher-description {
    display: flex;
    align-items: center;
    background-color: #eef4fa;
    padding: 10px;
    border-radius: 5px;
    color: #367FA9;
    font-size: 1.1em;
    margin-top: 10px;
}

.voucher-date {
    display: flex;
    align-items: center;
    border-radius: 5px;
    padding: 5px;
    margin-top: 10px;
}

.alert-icon {
    font-size: 1.2em;
    margin-right: 8px;
}

.voucher-terms {
    margin-top: 10px;
    padding-left: 18px;
    color: #555;
    font-size: 0.9em;
}

.voucher-terms li {
    margin-bottom: 5px;
}

.voucher-divider {
    border-top: 1px solid #ddd;
    margin: 15px 0;
}

.voucher-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.voucher-code {
    font-family: monospace;
    font-size: 1.1em;
    color: #367FA9;
    padding: 5px 10px;
    border: 1px dashed #367FA9;
    border-radius: 5px;
    background-color: #eef4fa;
}

.redeem-btn {
    background-color: #367FA9;
    border: none;
    color: #fff;
    padding: 10px 20px;
    font-size: 1em;
    border-radius: 5px;
    cursor: pointer;
}

.redeem-btn:hover {
    background-color: #2b6a85;
}

.create-voucher-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

/* Cart Icon Styles */
.footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: #367FA9;
    color: #fff;
    position: relative;
}

.footer-content {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.cart-icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: #fff;
    color: #367FA9;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.cart-icon-wrapper:hover {
    background-color: #2b6a85;
}

.cart-icon {
    font-size: 1.2em;
}
</style>
