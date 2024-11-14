<template>
    <section class="login">
        <div class="container login">
            <div class="login form">
                <header style="font-size:26px;">Reset Password</header>
                <form @submit.prevent="handleSubmit">

                    <!-- Password -->
                    <div class="mt-1">
                        <label for="password">Password</label>
                        <input id="password" type="password" v-model="form.password" placeholder="Enter your password"
                            class="form-control" required />
                        <span v-if="errors.password" class="text-danger">{{ errors.password }}</span>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-1">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" v-model="form.password_confirmation"
                            placeholder="Confirm your password" class="form-control" required />
                        <span v-if="errors.password_confirmation" class="text-danger">{{ errors.password_confirmation }}</span>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4">
                        <input type="submit" class="btn btn-success btn-block" :disabled="loading"
                            :value="loading ? 'Loading...' : 'Reset Password'" />
                    </div>
                </form>

                <div v-if="errors.general" class="mt-4 text-danger">
                    {{ errors.general }}
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAuthStore } from '@/Stores/auth';

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();

const form = ref({
    password: "",
    password_confirmation: "",
    email: route.query.email,
    token: route.params.token,
});

const errors = reactive({
    password: '',
    password_confirmation: '',
    general: '',
});

const loading = ref(false);

const handleSubmit = async () => {
    loading.value = true;
    errors.password = '';
    errors.password_confirmation = '';
    errors.general = '';

    try {
        const responseErrors = await authStore.handleResetPassword(form);

        if (responseErrors) {
            errors.password = responseErrors.password ? responseErrors.password[0] : '';
            errors.password_confirmation = responseErrors.password_confirmation ? responseErrors.password_confirmation[0] : '';
            errors.general = responseErrors.general ? responseErrors.general : '';
        } else {
            router.push('/login');
        }
    } catch (error) {
        errors.general = 'An unexpected error occurred. Please try again.';
        console.log(error); // Log the error for debugging
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
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

.text-danger {
    color: red;
}
</style>
