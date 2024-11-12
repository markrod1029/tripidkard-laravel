<template>
    <MenuBar />
    <Sidebar />

    <div class="content-wrapper">
        <Breadcrumb />
        <main class="page">
            <section class="shopping-cart mt-5">
                <div class="container">
                    <div class="">
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
                                                    <img class="img-fluid mx-auto d-block image" :src="product.image" />
                                                </div>
                                                <div class="col-md-8 pos">
                                                    <div class="info">
                                                        <div class="row">
                                                            <div class="col-md-5 product-name">
                                                                <a href="#">{{ product.product_name }}</a>
                                                                <div class="product-info">
                                                                    <div>AI Chatbot Deployment: <span class="value">{{ product.description }}</span></div>
                                                                    <div>Quantity: <span class="value">{{ product.quantity }}</span></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 quantity d-none">
                                                                <label for="quantity">Quantity:</label>
                                                                <input id="quantity" type="number" :value="product.quantity" class="form-control quantity-input">
                                                            </div>
                                                            <div class="col-md-3 price">
                                                                <span>₱{{ product.price }}</span>
                                                            </div>
                                                            <div class="col-md-5 button-group mt-2">
                                                                <button @click="confirmRemoveProduct(product.id)" class="btn btn-danger">Remove</button>
                                                                <router-link :to="`/customer/cart/${product.id}/features`" class="btn btn-primary ml-2 text-white">Edit</router-link>
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
                                    <router-link to="/services/chatbot-marketing" type="button" class="btn btn-primary bg-dark btn-lg btn-block">Back In Chatbot</router-link>
                                </div>
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
import Footer from '@/Components/Organisims/Footer.vue';
import Breadcrumb from '@/Components/Organisims/Breadcrum.vue';
import { reactive, computed } from 'vue';
import axios from 'axios';

const products = reactive([
    {
        id: 1,
        product_name: 'AI Chatbot Deployment',
        description: 'A solution for automating customer service.',
        quantity: 2,
        price: 500,
        image: '/storage/img/logo.jpg'
    },
    {
        id: 2,
        product_name: 'Web Development Service',
        description: 'Custom web development for your business.',
        quantity: 1,
        price: 1200,
        image: '/storage/img/logo.jpg'
    }
]);

const subtotal = computed(() => {
    return products.reduce((acc, product) => acc + (product.price * product.quantity), 0);
});

const discountAmount = 10; // Example static discount
const total = computed(() => {
    return subtotal.value * (1 - discountAmount / 100);
});

const confirmRemoveProduct = (id) => {
    const index = products.findIndex(product => product.id === id);
    if (index !== -1) {
        products.splice(index, 1); // Remove the product from the cart
    }
};

const checkout = () => {
    // Implement checkout functionality here
    console.log('Proceed to checkout');
};

// Optional: Fetch products dynamically if needed
// const fetchProducts = async () => {
//     try {
//         const response = await axios.get('/api/cart/products');
//         products.length = 0;  // Clear existing products
//         products.push(...response.data);
//     } catch (error) {
//         console.error("Error fetching products:", error);
//     }
// };

// fetchProducts();
</script>


<style scoped>
.shopping-cart {
    padding-bottom: 50px;
    font-family: 'Montserrat', sans-serif;
}

.shopping-cart .content {
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
    background-color: white;
}

.shopping-cart .block-heading {
    padding-top: 50px;
    margin-bottom: 40px;
    text-align: center;
}

.shopping-cart .block-heading p {
    text-align: center;
    max-width: 420px;
    margin: auto;
    opacity: 0.7;
}

.shopping-cart .dark .block-heading p {
    opacity: 0.8;
}

.shopping-cart .block-heading h1,
.shopping-cart .block-heading h2,
.shopping-cart .block-heading h3 {
    margin-bottom: 1.2rem;
    color: #3b99e0;
}

.shopping-cart .items {
    margin: auto;
}

.shopping-cart .items .product {
    margin-bottom: 20px;
    padding-top: 20px;
    padding-bottom: 20px;
}

.shopping-cart .items .product .info {
    padding-top: 0px;
    text-align: center;
}

.shopping-cart .items .product .info .product-name {
    font-weight: 600;
}

.shopping-cart .items .product .info .product-name .product-info {
    font-size: 14px;
    margin-top: 15px;
}

.shopping-cart .items .product .info .product-name .product-info .value {
    font-weight: 400;
}

.shopping-cart .items .product .info .quantity .quantity-input {
    margin: auto;
    width: 80px;
}

.shopping-cart .items .product .info .price {
    margin-top: 15px;
    font-weight: bold;
    font-size: 22px;
}

.shopping-cart .summary {
    border-top: 2px solid #5ea4f3;
    background-color: #f7fbff;
    height: 100%;
    padding: 30px;
}

.shopping-cart .summary h3 {
    text-align: center;
    font-size: 1.3em;
    font-weight: 600;
    padding-top: 20px;
    padding-bottom: 20px;
}

.shopping-cart .summary .summary-item:not(:last-of-type) {
    padding-bottom: 10px;
    padding-top: 10px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.shopping-cart .summary .text {
    font-size: 1em;
    font-weight: 600;
}

.shopping-cart .summary .price {
    font-size: 1em;
    float: right;
}

.shopping-cart .summary button {
    margin-top: 20px;
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
}

.button-group button {
    margin-right: 5px;
}


  .modal {
    margin-top: 10rem;
  }


@media (min-width: 768px) {
    .shopping-cart .items .product .info {
        padding-top: 25px;
        text-align: left;
    }

    .shopping-cart .items .product .info .price {
        font-weight: bold;
        font-size: 22px;
        top: 17px;
    }

    .shopping-cart .items .product .info .quantity {
        text-align: center;
    }
    .shopping-cart .items .product .info .quantity .quantity-input {
        padding: 4px 10px;
        text-align: center;
    }
}
</style>
