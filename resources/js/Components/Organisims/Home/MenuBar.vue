<template>
    <div>
        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-light fixed-top">
            <div class="container">
                <!-- Logo aligned to the left -->
                <router-link class="navbar-brand" to="/">
                    <img class="img-fluid" src="/storage/img/logo.jpg" alt="Tripidkard" width="100" />
                </router-link>

                <!-- Toggle button aligned to the right -->
                <button @click="toggleModal" class="navbar-toggler" type="button" aria-label="Toggle navigation">
                    <!-- Toggle icon based on modal state -->
                    <span class="text-dark" :class="showModal ? 'fa fa-times' : 'fa fa-bars'" ></span>
                </button>

                <!-- Navigation links aligned to the right -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <NavItem to="/" label="Home" />
                        <NavItem to="/tripidkard/details" label="Tripidkard" />
                        <NavItem to="/join" label="How To Join" />
                        <NavItem to="/scanner" label="Scanner" />
                        <NavItem to="/merchants" label="Merchants" />
                        <NavItem to="/contact-us" label="Contact" />

                        <!-- Conditional button for login or dashboard -->
                        <NavItem v-if="isLoggedIn" to="/login" label="Dashboard"
                            textClass="btn btn-primary font-weight-bold text-uppercase bg-primary" />
                        <NavItem v-else to="/login" label="Merchant Login"
                            textClass="btn btn-primary font-weight-bold text-uppercase bg-primary" />
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Modal (Mobile Menu Style) -->
        <div v-if="showModal" class="modal-overlay">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="closeModal" aria-label="Close">
                            <span aria-hidden="true" style="font-size:30px">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="menu-list">
                            <!-- List items as menu options -->
                            <li class="menu-item" @click="closeModal"><router-link to="/">Home</router-link></li>
                            <li class="menu-item" @click="closeModal"><router-link to="/tripidkard/details">Tripidkard</router-link></li>
                            <li class="menu-item" @click="closeModal"><router-link to="/join">How To Join</router-link></li>
                            <li class="menu-item" @click="closeModal"><router-link to="/scanner">Scanner</router-link></li>
                            <li class="menu-item" @click="closeModal"><router-link to="/merchants">Merchants</router-link></li>
                            <li class="menu-item" @click="closeModal"><router-link to="/contact-us">Contact</router-link></li>

                            <!-- Conditional button for login or dashboard -->
                            <li class="menu-item" @click="closeModal">
                                <router-link :to="isLoggedIn ? '/login' : '/login'" class="btn btn-primary text-uppercase">
                                    {{ isLoggedIn ? 'Dashboard' : 'Merchant Login' }}
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineComponent, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';

const NavItem = defineComponent({
    props: {
        to: String,
        label: String,
        textClass: {
            type: String,
            default: 'text-dark text-uppercase',
        },
    },
    template: `
        <li class="nav-item">
            <router-link :class="['nav-link', textClass]" :to="to">{{ label }}</router-link>
        </li>
    `,
});

// Reactive variable to manage modal visibility
const showModal = ref(false);

// Function to toggle the modal and icon state
const toggleModal = () => {
    showModal.value = !showModal.value;
};

// Function to close the modal
const closeModal = () => {
    showModal.value = false;
};

// Authentication check
const authStore = useAuthStore();
const isLoggedIn = ref(authStore.isAuthenticated);
</script>

<style scoped>
.navbar {
    z-index: 9999;
}

.modal-overlay {
    position: fixed;
    top: 40px; /* Just below the navbar */
    left: 0;
    width: 100%;
    height: 100%;
    height: calc(100% - 40px); /* Adjust to full height minus navbar height */
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    z-index: 9998;
    transition: opacity 0.3s ease;
}

.modal-dialog {
    width: 100%;
    height: 100%;
    margin: 0;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    text-align:center;
}

.modal-overlay .modal-dialog {
    transform: translateX(0);
}

.modal-content {
    width: 100%;
    height: 100%;
    background-color: white;
    padding: 0;
    overflow-y: auto;
}

.modal-header {
    padding: 10px;
    background-color: #007bff;
    color: white;
    text-align: right;
}

.modal-header .close {
    color: white;
    font-size: 30px;
    background: none;
    border: none;
}

.menu-list {
    list-style: none;
    margin: 0;
    padding: 20px;
}

.menu-item {
    padding: 15px;
    font-size: 20px;
    border-bottom: 1px solid #ddd;
}

.menu-item a {
    color: #333;
    text-decoration: none;
    display: block;
    padding: 10px;
    font-weight: bold;
}

.menu-item:hover {
    background-color: #f1f1f1;
}

@media (max-width: 768px) {
    .modal-dialog {
        width: 100%;
    }
}
</style>
