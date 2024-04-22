<template>
    <section class="login">
        <div class="container">
            <div class="wrapper">
                <div class="title"><span>TripidKard Sign In</span></div>
                <form method="POST" @submit.prevent="loginForm">
                    <div class='alert alert-danger alert-dismissible' v-if="errorMessage">
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true' @click="errorMessage = ''">&times;</button>
                        {{ errorMessage }}
                    </div>
                    <div class='alert alert-success alert-dismissible' v-if="successMessage">
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true' @click="successMessage = ''">&times;</button>
                        {{ successMessage }}
                    </div>
                    <div class="row">
                        <i class="fas fa-users icon"></i>
                        <input type="email" v-model="form.email" name="email" placeholder="Email" required>
                    </div>
                    <div class="row">
                        <i class="fas fa-lock icon"></i>
                        <span class="toggle-password" @click="togglePassword">
                            <span class="fa fa-fw" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></span>
                        </span>
                        <input :type="showPassword ? 'text' : 'password'" v-model="form.password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="pass"><a href="forgot-password">Forgot password?</a></div>
                    <div class="row button">
                        <button type="submit" name="login" class="btn btn-primary btn-block" :disabled="loading">
                            <div v-if="loading" class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span v-else>Sign In</span>
                        </button>
                    </div>
                    <div class="signup-link">Not a member? <a href="https://tripidkard.com/merchant-details">Signup now</a></div>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const form = ref({
    email: '',
    password: ''
});


const csrfToken = ref('');

const getCsrfToken = async () => {
    const response = await axios.get('/csrf-token');
    csrfToken.value = response.data.csrfToken;
}

onMounted(() => {
    getCsrfToken();
});

const loading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');
const showPassword = ref(false);

const togglePassword = () => {
    showPassword.value = !showPassword.value;
}

const loginForm = async () => {
    loading.value = true;
    try {
        const response = await axios.post('/login', form.value);
        // Handle success message if needed
        successMessage.value = response.data.message;
        // Redirect if login successful
        window.location.href = '/admin/dashboard';
    } catch(error) {
        if (error.response) {
            errorMessage.value = error.response.data.message;
        } else {
            errorMessage.value = "An error occurred.";
        }
    } finally {
        loading.value = false;
    }
}
</script>


<style scoped>
/* Add this CSS to your stylesheet or in a style block in your HTML */

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-dismissible {
    position: relative;
    padding-right: 35px;
}

.close {
    position: absolute;
    top: 5px;
    right: 10px;
    padding: 5px;
}

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

.login {
    margin: 0;
    padding: 0;
    background-image: url('https://tripidkard.com/wp-content/uploads/2023/10/bg-light.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    /* Optional: Prevents the background from scrolling */
    overflow: hidden;
}

::selection {
    background: rgba(26, 188, 156, 0.3);
}


a {
    text-decoration: none !important;
}

.container {
    max-width: 540px;
    padding: 0 20px;
    margin: 170px auto;
}

.wrapper {
    width: 100%;
    border-radius: 5px;
}

.signup-link,
a {
    text-decoration: none;
}

.wrapper .title {
    height: 90px;
    background: #2585bc;
    border-radius: 5px 5px 0 0;
    color: #fff;
    font-size: 30px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wrapper form {
    padding: 30px;
    box-shadow: 0px 4px 10px 1px rgba(0, 0, 0, 0.1);

}

.wrapper form .row {
    height: 45px;
    margin-bottom: 15px;
    position: relative;

}

.wrapper form .row input {
    height: 100%;
    width: 100%;
    outline: none;
    padding-left: 60px;
    border-radius: 5px;
    border: 1px solid lightgrey;
    font-size: 16px;
    transition: all 0.3s ease;
}

form .row input:focus {
    box-shadow: inset 0px 0px 2px 2px rgba(26, 126, 188, 0.25);
}

form .row input::placeholder {
    color: #999;
}

.wrapper form .row .icon {
    position: absolute;
    width: 47px;
    height: 100%;
    color: #fff;
    font-size: 18px;
    background: #2585bc;
    border: 1px solid #2585bc;
    border-radius: 5px 0 0 5px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wrapper form .pass {
    margin: -8px 0 20px 0;
}

.wrapper form .pass a {
    color: #2585bc;
    font-size: 17px;
    text-decoration: none;
}

.wrapper form .pass a:hover {
    text-decoration: underline;
}

.wrapper form .button input {
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    padding-left: 0px;
    background: #2585bc;
    border: 1px solid #2585bc;
    cursor: pointer;
}

form .button input:hover {
    background: #34a5e2;
}

.wrapper form .signup-link {
    text-align: center;
    margin-top: 20px;
    font-size: 17px;
}

.wrapper form .signup-link a {
    color: #2585bc;
    text-decoration: none;
}

form .signup-link a:hover {
    text-decoration: underline;
}

.wrapper form .row .toggle-password {
    position: absolute;
    right: 5%;
    /* Adjust the percentage as needed */
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2585bc;
}

.pass {
    padding-top: 5px;
}
</style>
