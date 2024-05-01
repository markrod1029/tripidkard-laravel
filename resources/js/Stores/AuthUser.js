import axios from 'axios';
import { reactive, ref, onMounted } from 'vue';
import { defineStore } from 'pinia';

export const useAuthUserStore = defineStore('AuthUser', () => {
    const users = ref({
        fname: '',
        mname: '',
        lname: '',
        contact: '',
        email: '',
        role: '',
        business_code : '',
        card_code  : '',
        business_name: '',
        business_category: '',
        business_sub_category: '',
        stars_points: '',
        zip: '',
        street: '',
        city: '',
        province: '',

    });

    const errorMessage = ref('');

    let getUser = async () => {
        try {
            const response = await axios.get('/api/profile');
            users.value = response.data;
        } catch (error) {
            if (error.response) {
                errorMessage.value = error.response.data.message;
            } else {
                errorMessage.value = "An error occurred.";
            }
        }
    };

    // Call getUser when component is mounted
    onMounted(() => {
        getUser();
    });

    return {
        users,
        errorMessage,
    };
});
