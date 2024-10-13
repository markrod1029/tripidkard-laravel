<template>
    <div class="small-box bg-default" style="background-color:white;">
        <div class="card-body">
            <center class="mt-4">
                <!-- Input field for file -->
                <input @change="handleFileChange" ref="fileInput" type="file" name="" class="d-none">
                <!-- Display image -->
                <img @click="openFileInput" id="imageResult" height="150" width="150" :src="profilePictureUrl ? profilePictureUrl : authUser.users.avatar"
                    class="img-circle" alt="User Image">
                <!-- User details -->
                <h4 class="card-subtitle mt-2">
                    {{ authUser.users.fname }} {{ authUser.users.mname }} {{ authUser.users.lname }}
                </h4>
                <h5 class="card-subtitle">
                    {{ authUser.users.role }}
                </h5>
            </center>
        </div>
        <hr>
        <div class="card-body" style="margin-left:30px;">
            <!-- User details -->
            <small class="text-muted">Business Code</small>
            <h6>{{ authUser.users.business_code }}</h6>
            <!-- Add other user details here -->
        </div>
    </div>
</template>

<script setup>
import { useAuthUserStore } from '@/Stores/AuthUser';
import { ref, watch } from 'vue';
import { useToastr } from '@/toastr.js';
import axios from 'axios';

const authUser = useAuthUserStore();
const toastr = useToastr();
const fileInput = ref(null);
const profilePictureUrl = ref(null);

// Open file input when image is clicked
const openFileInput = async () => {
    fileInput.value.click();
}

// Handle file change when a new image is selected
const handleFileChange = async (event) => {
    const file = event.target.files[0];
    profilePictureUrl.value = URL.createObjectURL(file);

    const formData = new FormData();
    formData.append('profile_picture', file);

    try {
        const response = await axios.post('/api/upload-profile-image', formData);
        const message = response.data.message;
        toastr.success(message);
    } catch (error) {
        console.error(error);
        toastr.error('Failed to upload image');
    }
}

// Watch for changes in the user's avatar
watch(() => authUser.users.avatar, (newValue, oldValue) => {
    // Update profile picture URL when avatar changes
    profilePictureUrl.value = newValue;

});
</script>

<style scoped>
.img-circle:hover {
    border: 3 solid blue;
    cursor: pointer;
}
</style>
