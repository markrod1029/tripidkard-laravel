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
                        <!-- Display selected image -->
                        <img v-if="imagePreview.photo1" :src="imagePreview.photo1" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 2</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="photo2" @change="previewImage($event, 'photo2')">
                        <!-- Display selected image -->
                        <img v-if="imagePreview.photo2" :src="imagePreview.photo2" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12 text-left control-label col-form-label text-muted">Photo 3</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="photo3" @change="previewImage($event, 'photo3')">
                        <!-- Display selected image -->
                        <img v-if="imagePreview.photo3" :src="imagePreview.photo3" class="mt-2" alt="Selected Image" style="max-width: 150px; max-height: 150px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Upload Images</button>
            </form>
        </div>
    </div>
    <!-- End Change Images -->
</template>

<script setup>
import { reactive } from 'vue';
import axios from 'axios';

const imagePreview = reactive({
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
    } catch (error) {
        console.error('Error uploading images:', error);
    }
};
</script>


