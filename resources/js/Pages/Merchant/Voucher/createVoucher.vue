<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">

                <!-- Create Voucher Button  -->
                <div class="d-flex align-items-center">
                    <button class="btn btn-primary create-voucher-btn ms-2" @click="openModal">
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
                                    <button class="btn btn-primary redeem-btn" >
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

    <!-- Create Voucher Modal -->
    <div v-if="isModalOpen" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
            <h3 class="modal-title">Create New Voucher</h3>
            <form @submit.prevent="createVoucher">
                <div class="form-group">
                    <label for="code">Voucher title</label>
                    <input type="text" id="code" v-model="newVoucher.title" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" v-model="newVoucher.description" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="terms">Voucher Terms</label>
                    <textarea id="terms" v-model="newVoucher.terms" class="form-control" placeholder="Separate terms with commas" required></textarea>
                </div>
                <div class="form-group">
                    <label for="terms">Total Loyalty Points</label>
                    <input type="number" class="form-control" v-model="newVoucher.points" name="points" required="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import Cart from '@/Pages/Merchant/Orders/cartIcon.vue';
import { useRouter } from 'vue-router';
import { reactive, ref } from 'vue';
import { useToastr } from '@/toastr.js';
import axios from 'axios';

const formatDate = (date) => {
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
    return new Date(date).toLocaleDateString('en-US', options);
};


const router = useRouter();
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

// Modal state
const isModalOpen = ref(false);
const newVoucher = reactive({
    title: '',
    description: '',
    terms: '',
    points: '',

});

// Open and close modal
const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    resetForm();
};

const resetForm = () => {
    newVoucher.title = '';
    newVoucher.description = '';
    newVoucher.terms = '';
    newVoucher.points = '';
};

// Create Voucher logic
const createVoucher = async () => {
    if (!newVoucher.title || !newVoucher.description || !newVoucher.terms || !newVoucher.points) {
        toastr.error('Please fill in all fields');
        return;
    }

    try {
        const response = await axios.post('/api/voucher/create', newVoucher);
        toastr.success(response.data.message || 'Voucher created successfully');
        router.push('/merchant/order/cart');
        // Optionally, update the voucher list here
    } catch (error) {
        console.error(error);
        toastr.error(error.response?.data?.message || 'Failed to create voucher');
    }
};


</script>

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

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.modal-title {
    font-size: 1.5em;
    color: #367FA9;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1em;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #367FA9;
}

.modal-footer {
    display: flex;
    justify-content: space-between;
}

.btn-secondary {
    background-color: #f0f0f0;
    color: #555;
}

.btn-secondary:hover {
    background-color: #ddd;
}

.btn-primary {
    background-color: #367FA9;
    color: white;
}

.btn-primary:hover {
    background-color: #2b6a85;
}
</style>
