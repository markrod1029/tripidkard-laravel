<template>
    <!-- Banner section -->
    <div class="banner-container">
        <transition-group name="zoomFade" tag="div">
            <div v-for="(image, index) in images" :key="index" class="banner-image"
                :style="{ zIndex: index, opacity: (index === currentImageIndex) ? 1 : 0 }">
                <img :src="image" alt="Banner Image" class="img-fluid zoom-effect">
                <div class="overlay">
                    <div class="tagline">

                        <h1 class=" title font-weight-bold ">
                            Reach Out and Connect with Us
                        </h1>
                    </div>
                    <!-- <div class="tagline">Your tagline here</div> -->
                </div>
            </div>
        </transition-group>
    </div>

</template>

<style scoped>
.banner-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    height: 40vh;
    /* Adjust height as needed */
}

.banner-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.banner-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    /* Black background with 70% opacity */
}

.title {
    color: white;
    font-size: 45px;
    text-align: center;
    margin-top: 11%;

}

.zoomFade-enter-active,
.zoomFade-leave-active {
    transition: opacity 1s ease-in-out;
    /* Adjust timing function */
}

.zoomFade-enter,
.zoomFade-leave-to {
    opacity: 0;
}

.zoom-effect {
    animation: zoom 5s infinite alternate ease-in-out;
}

@keyframes zoom {
    from {
        transform: scale(1);
    }

    to {
        transform: scale(1.2);
    }
}


/* Mobile and Tablet View */
@media (max-width: 1024px) {
    .title {
        text-align: center;
    }

    .tagline {
        position: absolute;
        top: 13%;
        width: 90%;
        left: 35px;

    }

}

/* Mobile View (For smaller screens) */
@media (max-width: 768px) {
    .title {
        font-size: 30px;
        /* Adjust for smaller mobile screens */

    }

    .tagline {
        position: absolute;
        top: 40%;
        width: 90%;
        left: 15px;
    }
}
</style>

<script>
export default {
    data() {
        return {
            images: [
                '/storage/banner/Sunflower-Maze-750x400-1.webp',
                '/storage/banner/sual.jpg',
                '/storage/banner/Manaoag-Church-is-Famous.webp',
                '/storage/banner/hundred-island .jpg',
                '/storage/banner/10-Must-Visit-Places-in-Pangasinan-That-Are-Perfect-for-Kids-and-the-Whole-Family.webp',


            ],
            currentImageIndex: 0
        };
    },
    mounted() {
        this.startImageTransition();
    },
    methods: {
        startImageTransition() {
            setInterval(() => {
                this.currentImageIndex = (this.currentImageIndex + 1) % this.images.length;
            }, 5000); // Change image every 5 seconds
        }
    }
}
</script>
