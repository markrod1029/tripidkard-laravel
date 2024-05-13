<template>
    <!-- Banner section -->
    <div class="banner-container">
      <transition-group name="zoomFade" tag="div">
        <div v-for="(image, index) in images" :key="index" class="banner-image" :style="{ zIndex: index, opacity: (index === currentImageIndex) ? 1 : 0 }">
          <img :src="image" alt="Banner Image" class="img-fluid zoom-effect">
          <div class="overlay"></div>
          <div class="tagline">Your tagline here</div>
        </div>
      </transition-group>
    </div>

    <!-- Boxes with images and text -->
    <div class="box-container">
      <div class="box">
        <div class="box-overlay"></div>
        <img src="your-image-url.jpg" alt="Box Image">
        <div class="box-content">
          <h2>Box Title 1</h2>
          <p>Box Description 1</p>
          <a href="#" class="button">Click Here</a>
        </div>
      </div>
      <div class="box">
        <div class="box-overlay"></div>
        <img src="your-image-url.jpg" alt="Box Image">
        <div class="box-content">
          <h2>Box Title 2</h2>
          <p>Box Description 2</p>
          <a href="#" class="button">Click Here</a>
        </div>
      </div>
      <div class="box">
        <div class="box-overlay"></div>
        <img src="your-image-url.jpg" alt="Box Image">
        <div class="box-content">
          <h2>Box Title 3</h2>
          <p>Box Description 3</p>
          <a href="#" class="button">Click Here</a>
        </div>
      </div>
    </div>

    <!-- Your page content goes here -->
    <h1>{{ $route.meta.title }}</h1>
  </template>

  <style>
  /* Existing styles for banner */
  .banner-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    height: 88vh; /* Adjust height as needed */
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
    background-color: rgba(0, 0, 0, 0.7); /* Black background with 70% opacity */
  }

  .tagline {
    position: absolute;
    bottom: 20px; /* Adjust as needed */
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 24px;
    font-weight: bold;
    text-align: center;
  }

  /* New styles for boxes */
  .box-container {
    display: flex;
    justify-content: space-around;
    margin-top: 50px;
  }

  .box {
    position: relative;
    width: 30%;
    overflow: hidden;
  }

  .box img {
    width: 100%;
    height: auto;
  }

  .box-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); /* Black overlay */
    opacity: 0; /* Initially hidden */
    transition: opacity 0.3s ease;
  }

  .box:hover .box-overlay {
    opacity: 1; /* Show on hover */
  }

  .box-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
  }

  .box-content h2 {
    font-size: 24px;
    margin-bottom: 10px;
  }

  .box-content p {
    font-size: 16px;
    margin-bottom: 20px;
  }

  .button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ffffff;
    color: #000000;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .button:hover {
    background-color: #dddddd;
  }
  </style>

  <script>
  export default {
    data() {
      return {
        images: [
          'https://images.saymedia-content.com/.image/t_share/MjAzMDI5MjI3NjMxNTUxNjcw/top-10-tourist-destination-in-the-philippines.jpg',
          'https://www.planetware.com/photos-large/PHI/philippines-albay-mayon-volcano.jpg',
          'https://i0.wp.com/www.pacificprime.cn/blog/wp-content/uploads/2024/03/Banaue-Rice-Terraces.png?resize=700%2C304&ssl=1'
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
