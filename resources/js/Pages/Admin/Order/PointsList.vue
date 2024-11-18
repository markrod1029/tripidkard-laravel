<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body mt-3 mb-3 ml-2 mr-2">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="col-3">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="Search orders..." />
                            </div>
                        </div>

                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="ordersTable" class="display dataTable table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Business Name</th>
                                                <th>Order</th>
                                                <th>Order Type</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Action</th> <!-- Added Action column -->
                                            </tr>
                                        </thead>
                                        <tbody v-if="paginatedOrders.length > 0">
                                            <tr v-for="(order, index) in paginatedOrders" :key="order.id">
                                                <td>{{ (currentPage - 1) * ordersPerPage + index + 1 }}</td>
                                                <td>{{ order.business_name }}</td>
                                                <td>{{ order.Name }} Card</td>
                                                <td>{{ order.type }}</td>
                                                <td>{{ order.total }}</td>
                                                <td>{{ order.status }}</td>
                                                <td>{{ formatRelativeTime(order.created_at) }}</td>
                                                <td>
                                                    <button class="btn btn-success" @click="acceptOrder(order.id)">Accept</button> <!-- Accept button -->
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="8" class="text-center">No Orders Found</td> <!-- Adjusted colspan -->
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Pagination Controls -->
                                    <nav>
                                        <ul class="pagination justify-content-left">
                                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                                <button class="page-link" @click="goToPage(currentPage - 1)">Previous</button>
                                            </li>
                                            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                                                <button class="page-link" @click="goToPage(page)">{{ page }}</button>
                                            </li>
                                            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                                <button class="page-link" @click="goToPage(currentPage + 1)">Next</button>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <Footer />
</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Admin/Sidebar.vue';
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';

import { useToastr } from '@/toastr.js';
import axios from 'axios';
import { ref, onMounted, computed, watch } from 'vue';
import { debounce } from 'lodash';

const toastr = useToastr();
const orders = ref([]);
const searchQuery = ref('');
const currentPage = ref(1);
const ordersPerPage = 10;

// Fetch orders from the API
const getOrders = async () => {
    try {
        const response = await axios.get('/api/order/lists', {
            params: { query: searchQuery.value },
        });
        orders.value = response.data;
    } catch (error) {
        console.error('Error fetching orders:', error);
    }
};

// Watch the search query and debounce the API call
watch(searchQuery, debounce(() => {
    currentPage.value = 1; // Reset to the first page on search
    getOrders();
}, 100));

onMounted(() => {
    getOrders();
});

// Computed property for paginated orders
const paginatedOrders = computed(() => {
    const start = (currentPage.value - 1) * ordersPerPage;
    return orders.value.slice(start, start + ordersPerPage);
});

// Computed property for total pages
const totalPages = computed(() => {
    return Math.ceil(orders.value.length / ordersPerPage);
});

// Function to navigate to a specific page
const goToPage = (page) => {
    if (page < 1 || page > totalPages.value) return;
    currentPage.value = page;
};

// Format the created_at field as relative time
const formatRelativeTime = (timestamp) => {
    const now = new Date();
    const createdAt = new Date(timestamp);
    const difference = now - createdAt;

    const seconds = Math.floor(difference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) {
        return `${days} day(s) ago`;
    } else if (hours > 0) {
        return `${hours} hour(s) ago`;
    } else if (minutes > 0) {
        return `${minutes} minute(s) ago`;
    } else {
        return `${seconds} second(s) ago`;
    }
};

// Accept the order
const acceptOrder = async (orderId) => {
    try {
        await axios.post(`/api/order/accept/${orderId}`);
        toastr.success('Order Accepted');
        getOrders(); // Refresh the orders after accepting
    } catch (error) {
        console.error('Error accepting order:', error);
        toastr.error('Failed to accept the order');
    }
};
</script>

<style scoped>
.content-wrapper {
    margin-top: 20px;
}
</style>
