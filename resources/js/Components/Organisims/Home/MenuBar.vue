<template>
    <div>
      <!-- Navigation bar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-light" style="height: 12vh; font-size: 18px;">
        <div class="container">
          <div class="row w-100">
            <!-- Logo aligned to the left -->
            <div class="col-auto">
              <a class="navbar-brand" href="#">
                <img src="https://tripidkard.com/wp-content/uploads/2023/10/cropped-tripid-card-ver.-2-1.png" alt="Tripidkard" width="100" >
              </a>
            </div>

            <!-- Spacer to push toggle button to the right -->
            <div class="col"></div>

            <!-- Toggle button aligned to the right -->
            <div class="col-auto">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <!-- Bootstrap classes for hiding text on smaller screens -->
                <span class="sr-only">Toggle navigation</span>
                <!-- Font Awesome icon for the toggle button -->
                <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
              </button>
            </div>
          </div>

          <!-- Navigation links -->
          <div class="collapse navbar-collapse " style="letter-spacing: 2px; " id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link text-dark text-uppercase" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark text-uppercase" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark text-uppercase" href="#">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark text-uppercase" href="#">Contact</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    <!-- Banner section -->
    <div class="banner-container">
      <transition name="zoomFade" mode="out-in">
        <img v-bind:src="currentImage" alt="Banner Image" class="img-fluid">
      </transition>
    </div>

    <!-- Your page content goes here -->
    <h1>{{ $route.meta.title }}</h1>
  </div>
</template>

<style>
.banner-container {
  width: 100%;
  overflow: hidden;
  height: 100vh;
}

.banner-container img {
  width: 100%;
  height: auto;
  object-fit: cover;
}

.zoomFade-enter-active, .zoomFade-leave-active {
  transition: opacity 1s, transform 5s cubic-bezier(0.645, 0.045, 0.355, 1); /* Mas makinis na transition effect */
}

.zoomFade-enter, .zoomFade-leave-to {
  opacity: 0;
  transform: scale(0.8); /* Zoom in effect */
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
  computed: {
    currentImage() {
      return this.images[this.currentImageIndex];
    }
  },
  mounted() {
    this.startImageTransition();
  },
  methods: {
    startImageTransition() {
      setInterval(() => {
        this.currentImageIndex = (this.currentImageIndex + 1) % this.images.length;
      }, 5000); // Change image every 5 seconds

      // Apply zoom effect after initial rendering
      setTimeout(() => {
        document.querySelector('.banner-container img').style.transform = 'scale(1)';
      }, 100); // Adjust timing as needed
    }
  }
}
</script>
