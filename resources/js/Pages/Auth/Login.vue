<template>
    <se class="login">
        <div class="container login">
            <div class="login form">
                <header>Login</header>
                <form @submit.prevent="handleSubmit">
                    <!-- Email Address -->
                    <div>
                        <label for="email">Email</label>
                        <input id="email" type="email" v-model="form.email" placeholder="Enter your email"
                            class="form-control" required autofocus />
                        <span v-if="errors.email" class="text-danger">
                            {{ errors.email }}
                        </span>
                    </div>
                    <!-- Password -->
                    <div class="mt-1">
                        <label for="password">Password</label>
                        <input id="password" type="password" v-model="form.password" placeholder="Enter your password"
                            class="form-control" required />
                        <span v-if="errors.password" class="text-danger">
                            {{ errors.password }}
                        </span>
                    </div>

                    <router-link to="/forgot-password" class="forgot">Forgot password?</router-link>

                    <!-- Submit Button -->
                    <div class="mt-4">
                        <input type="submit" class="btn btn-success btn-block" :disabled="loading"
                            :value="loading ? 'Loading...' : 'Sign In'" />
                    </div>

                    <span v-if="errors.general" class="text-danger">
                        {{ errors.general }}
                    </span>
                </form>
            </div>
        </div>
    </se>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/Stores/auth';

const authStore = useAuthStore();
const router = useRouter();

const form = reactive({
    email: '',
    password: '',
});

const errors = reactive({
    email: '',
    password: '',
    general: '',
});

const loading = ref(false);



const handleSubmit = async () => {
    loading.value = true;
    errors.email = '';
    errors.password = '';
    errors.general = '';

    try {
        const responseErrors = await authStore.loginForm(form);

        if (responseErrors) {
            errors.email = responseErrors.email ? responseErrors.email[0] : '';
            errors.password = responseErrors.password ? responseErrors.password[0] : '';
            errors.general = responseErrors.general ? responseErrors.general : '';
        } else {
            // Handle successful login and redirect based on role
            const userRole = authStore.user.role;
            if (userRole === 'Admin') {
                router.push('/admin/dashboard');
            } else if (userRole === 'Merchant') {
                router.push('/merchant/dashboard');
            } else if (userRole === 'Influencer') {
                router.push('/influencer/dashboard');
            } else {
                router.push('/');
            }
        }
    } catch (error) {
        errors.general = 'An unexpected error occurred. Please try again.';
        console.log(error); // Log the error for debugging
    } finally {
        loading.value = false;
    }
};


onMounted(async () => {
    await authStore.getUser();
});
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

.forgot {
    text-decoration: none !important;
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
</style>
