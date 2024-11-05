<template>
    <!-- Start Change Images -->
    <div class="tab-pane fade" id="pills-images" role="tabpanel" aria-labelledby="pills-images-tab">
        <div class="card-body">
            <form class="form-horizontal form-material" @submit.prevent="uploadImages">
                <!-- Profile/Update Images -->

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 1</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="photo1" @change="previewImage($event, 'photo1')">
                        <img v-if="imagePreview.photo1" :src="imagePreview.photo1" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                        <img v-if="authUser.users.photo1" :src="authUser.users.photo1" class="mt-2" alt="Existing Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 2</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="photo2" @change="previewImage($event, 'photo2')">
                        <img v-if="imagePreview.photo2" :src="imagePreview.photo2" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                        <img v-if="authUser.users.photo2" :src="authUser.users.photo2" class="mt-2" alt="Existing Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 3</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="photo3" @change="previewImage($event, 'photo3')">
                        <img v-if="imagePreview.photo3" :src="imagePreview.photo3" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                        <img v-if="authUser.users.photo3" :src="authUser.users.photo3" class="mt-2" alt="Existing Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Upload Images</button>
            </form>
        </div>
    </div>
    <!-- End Change Images -->
</template>

<script setup>
import { useAuthUserStore } from '@/Stores/AuthUser';

import { reactive, onMounted } from 'vue';
import axios from 'axios';

const authUser = useAuthUserStore();
const imagePreview = reactive({
    photo1: null,
    photo2: null,
    photo3: null,
});

const existingImages = reactive({
    photo1: null,
    photo2: null,
    photo3: null,
});

const previewImage = (event, photoKey) => {
    const file = event.target.files[0];
    if (file) {
        imagePreview[photoKey] = URL.createObjectURL(file);
    }
};

const uploadImages = async () => {
    try {
        const formData = new FormData();
        formData.append('photo1', document.querySelector('[name="photo1"]').files[0]);
        formData.append('photo2', document.querySelector('[name="photo2"]').files[0]);
        formData.append('photo3', document.querySelector('[name="photo3"]').files[0]);

        const response = await axios.post('/api/profile/upload-background-image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        console.log(response.data.message);
        alert(response.data.message);
        // Optionally refresh existing images after upload
        fetchExistingImages();
    } catch (error) {
        console.error('Error uploading images:', error);
    }
};

// Function to fetch existing images from the server
const fetchExistingImages = async () => {
    try {
        const response = await axios.get('/api/profile/get-existing-images'); // Adjust the API endpoint as needed
        existingImages.photo1 = response.data.photo1 || null;
        existingImages.photo2 = response.data.photo2 || null;
        existingImages.photo3 = response.data.photo3 || null;
    } catch (error) {
        console.error('Error fetching existing images:', error);
    }
};

// Fetch existing images when the component mounts
onMounted(() => {
    fetchExistingImages();
});
</script>
