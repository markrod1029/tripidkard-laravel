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
  </div>
</template>
