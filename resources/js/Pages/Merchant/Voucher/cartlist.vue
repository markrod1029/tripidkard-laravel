<template>
    <MenuBar />
    <Sidebar />
    <div class="content-wrapper">
        <Breadcrumb />
        <main class="page">
            <section class="shopping-cart mt-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-8">
                            <div class="items">
                                <div v-if="products.length === 0" class="no-products-message">
                                    <p>No products available in your cart.</p>
                                </div>
                                <div v-else>
                                    <div v-for="product in products" :key="product.id" class="product">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img class="img-fluid mx-auto d-block image" src="/storage/img/logo.jpg" />
                                            </div>
                                            <div class="col-md-8 pos">
                                                <div class="info">
                                                    <div class="row">
                                                        <div class="col-md-5 product-name">
                                                            <a href="#">{{ product.title }}</a>
                                                            <div class="product-info">
                                                                <div>AI Chatbot Deployment: <span class="value">{{ product.terms }}</span></div>
                                                                <div>Quantity: <span class="value">{{ product.quantity }}</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 price">
                                                            <span>₱{{ product.points }}</span>
                                                        </div>
                                                        <div class="col-md-5 button-group mt-2">
                                                            <button @click="confirmDeleteProduct(product.id)" class="btn btn-danger">Remove</button>
                                                            <button @click="openEditModal(product)" class="btn btn-primary ml-2 text-white">Edit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            <div class="summary">
                                <h3>Summary</h3>
                                <div class="summary-item"><span class="text">Subtotal</span><span class="price">₱{{ subtotal.toFixed(2) }}</span></div>
                                <div class="summary-item"><span class="text">Discount</span><span class="price">{{ discountAmount }}%</span></div>
                                <div class="summary-item"><span class="text">Total</span><span class="price">₱{{ total.toFixed(2) }}</span></div>
                                <button @click="checkout" type="button" class="btn btn-primary bg-primary btn-lg btn-block">Checkout</button>
                                <router-link to="/services/chatbot-marketing" class="btn btn-dark btn-lg btn-block">Back to Chatbot</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script setup>
import MenuBar from '@/Components/Organisims/MenuBar.vue';
import Sidebar from '@/Components/Organisims/Merchant/Sidebar.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { reactive, computed, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const products = reactive([]);
const isEditModalVisible = reactive(false);
const editProduct = reactive({});
const productToDelete = reactive({ id: null }); // Store the product ID for deletion

// Subtotal calculation
const subtotal = computed(() => {
    return products.reduce((acc, product) => acc + (product.points * product.quantity), 0);
});

// Static discount percentage
const discountAmount = 10; // Example static discount
const total = computed(() => subtotal.value * (1 - discountAmount / 100));

// Delete the product after confirmation
const confirmDeleteProduct = (productId) => {
    productToDelete.id = productId; // Store the product ID
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                // Perform the deletion
                await axios.delete(`/api/voucher/${productId}`);
                // Remove the product from the local array
                const index = products.findIndex(product => product.id === productId);
                if (index !== -1) {
                    products.splice(index, 1);
                }

                // Show success alert
                Swal.fire('Deleted!', 'Your product has been deleted.', 'success');
            } catch (error) {
                console.error("Error deleting product:", error);
                // Show error alert
                Swal.fire('Error!', 'There was an issue deleting the product.', 'error');
            }
        }
    });
};

// Fetch products (vouchers) from API
const fetchVouchers = async () => {
    try {
        const response = await axios.get('/api/voucher');
        products.length = 0; // Clear existing products
        if (response.data && Array.isArray(response.data)) {
            products.push(...response.data); // Add fetched products to the list
        }
    } catch (error) {
        console.error("Error fetching vouchers:", error);
    }
};

// Checkout function
const checkout = () => {
    console.log('Proceed to checkout');
};

// Open edit modal
const openEditModal = (product) => {
    editProduct.id = product.id;
    editProduct.title = product.title;
    editProduct.description = product.description;
    editProduct.terms = product.terms;
    editProduct.points = product.points;
    isEditModalVisible.value = true;
};

// Close edit modal
const closeEditModal = () => {
    isEditModalVisible.value = false;
};

// Update product
const updateProduct = async () => {
    try {
        const response = await axios.put(`/api/voucher/${editProduct.id}`, editProduct);
        const updatedProduct = response.data.voucher;

        // Update the product in the products array
        const index = products.findIndex(product => product.id === updatedProduct.id);
        if (index !== -1) {
            products.splice(index, 1, updatedProduct);
        }

        closeEditModal();
    } catch (error) {
        console.error("Error updating voucher:", error);
    }
};

// Fetch products on component mount
onMounted(() => {
    fetchVouchers();
});
</script>


<style scoped>
.shopping-cart {
    padding-bottom: 50px;
    font-family: 'Montserrat', sans-serif;
}

.shopping-cart .items .product {
    margin-bottom: 20px;
    padding-top: 20px;
    padding-bottom: 20px;
}

.shopping-cart .items .product .info .product-name .product-info {
    font-size: 14px;
    margin-top: 15px;
}

.shopping-cart .items .product .info .price {
    font-weight: bold;
    font-size: 22px;
}

.summary {
    border-top: 2px solid #5ea4f3;
    background-color: #f7fbff;
    padding: 30px;
}

.summary .summary-item:not(:last-of-type) {
    padding-bottom: 10px;
    padding-top: 10px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.summary .text, .summary .price {
    font-size: 1em;
    font-weight: 600;
}

.no-products-message {
    text-align: center;
    margin-top: 20px;
    font-size: 1.2em;
    font-weight: bold;
    color: #ff0000;
}

.button-group {
    display: flex;
    justify-content: start;
    gap: 5px;
}

@media (min-width: 768px) {
    .shopping-cart .items .product .info {
        padding-top: 25px;
        text-align: left;
    }
}

/* Modal styles */
.modal {
    display: block;
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1050;
}

.modal-dialog {
    position: relative;
    margin: 10% auto;
    max-width: 500px;
}
</style>
