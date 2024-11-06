<template>
  <!-- Banner section -->
  <div class="banner-container">
    <transition-group name="zoomFade" tag="div">
      <div
        v-for="(image, index) in bannerImages"
        :key="index"
        class="banner-image"
        :style="{ zIndex: index, opacity: (index === currentImageIndex) ? 1 : 0 }"
      >
        <img :src="image" alt="Banner Image" class="img-fluid zoom-effect">
        <div class="overlay">
          <h1 class="title font-weight-bold container">
            {{ merchant.tagline }}
          </h1>
        </div>
      </div>
    </transition-group>
  </div>
</template>

<script>
export default {
  props: {
    merchant: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      defaultImages: [
        '/storage/banner/Sunflower-Maze-750x400-1.webp',
        '/storage/banner/sual.jpg',
        '/storage/banner/Manaoag-Church-is-Famous.webp',
      ],
      currentImageIndex: 0,
    };
  },
  computed: {
    bannerImages() {
      // Log the paths to verify
      const images = [
        this.merchant.photo1 ? `/storage/${this.merchant.photo1}` : this.defaultImages[0],
        this.merchant.photo2 ? `/storage/${this.merchant.photo2}` : this.defaultImages[1],
        this.merchant.photo3 ? `/storage/${this.merchant.photo3}` : this.defaultImages[2],
      ];
      console.log("Banner images:", images); // Log images array to debug
      return images;
    },
  },
  mounted() {
    this.startImageTransition();
  },
  methods: {
    startImageTransition() {
      setInterval(() => {
        this.currentImageIndex = (this.currentImageIndex + 1) % this.bannerImages.length;
      }, 5000); // Change image every 5 seconds
    },
  },
};
</script>

<style scoped>
  .banner-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    height: 70vh; /* Adjust height as needed */
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
    background-color: rgba(0, 0, 0, 0.6); /* Black background with 60% opacity */
  }

  .title {
    color: white;
    font-size: 45px;
    text-align: center;
    margin-top: 18%;
  }

  .zoomFade-enter-active, .zoomFade-leave-active {
    transition: opacity 1s ease-in-out; /* Adjust timing function */
  }

  .zoomFade-enter, .zoomFade-leave-to {
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
</style>
