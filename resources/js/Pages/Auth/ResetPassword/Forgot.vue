<template>
    <div class="login">
        <div class="container login">
            <div class="login form">
                <header style="font-size:26px;">Forgot Password</header>
                <form @submit.prevent="handleSubmit">
                    <!-- Email Address -->
                    <div>
                        <label for="email">Email</label>
                        <input
                            id="email"
                            type="email"
                            v-model="email"
                            placeholder="Enter your email"
                            class="form-control"
                            required
                            autofocus
                        />
                        <span v-if="errorMessage" class="text-danger">{{ errorMessage }}</span>
                        <span v-if="successMessage" class="text-success">{{ successMessage }}</span>
                    </div>

                    <div class="mt-4">
                        <input
                            type="submit"
                            class="btn btn-success btn-block"
                            :value="loading ? 'Sending...' : 'Send'"
                            :disabled="loading"
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/Stores/auth';
import { useRouter } from 'vue-router';
import axios from 'axios';

const authStore = useAuthStore();
const router = useRouter();

const email = ref('');
const loading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

// Handle the form submission
const handleSubmit = async () => {
    loading.value = true;
    errorMessage.value = '';
    successMessage.value = '';

    try {
        const response = await authStore.handleForgotPassword(email.value);
        if (response.error) {
            errorMessage.value = response.error;  // Show error message if any
        } else {
            successMessage.value = 'Password reset link has been sent to your email.';  // Success message
        }
    } catch (error) {
        errorMessage.value = 'An unexpected error occurred. Please try again later.';
        console.error('Error during password reset request:', error);
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
/* Import Google font - Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

.login {
    margin: 0;
    padding: 0;
    background-image: url('https://tripidkard.com/wp-content/uploads/2023/10/bg-light.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    overflow: hidden;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    min-height: 120vh;
    width: 100%;
    background: #ffffff;
}

.container {
    margin-top: 380px;
    position: absolute;
    top: 20%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 430px;
    width: 100%;
    background: #fff;
    border-radius: 7px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
}

.container .form {
    padding: 2rem;
}

.form header {
    font-size: 2rem;
    font-weight: 500;
    text-align: center;
    margin-bottom: 1.5rem;
}

.form input {
    height: 50px;
    width: 100%;
    padding: 0 15px;
    font-size: 17px;
    margin-bottom: 1.3rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    outline: none;
}

.form input:focus {
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
}

.form a {
    font-size: 16px;
    color: #0275d8;
    text-decoration: none;
}

.form a:hover {
    text-decoration: underline;
}

.form .btn {
    color: #fff;
    background: #0275d8;
    font-size: 1.2rem;
    font-weight: 500;
    letter-spacing: 1px;
    margin-top: 1.4rem;
    cursor: pointer;
    transition: 0.4s;
}

.form .btn:hover {
    background: #025aa5;
}

.signup {
    font-size: 17px;
    text-align: center;
}

.signup label {
    color: #0275d8;
    cursor: pointer;
}

.signup label:hover {
    text-decoration: underline;
}

.text-danger {
    color: red;
}

.text-success {
    color: green;
}
</style>
