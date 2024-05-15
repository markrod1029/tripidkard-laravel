<template>
    <div>
      <!-- Navigation bar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-light fixed-top" style="height: 12vh;  font-family: Poppins, sans-serif; font-size:15px; font-weight: bold; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);">
        <div class="container">
          <!-- Logo aligned to the left -->
          <a class="navbar-brand" href="/">
            <img src="https://tripidkard.com/wp-content/uploads/2023/10/cropped-tripid-card-ver.-2-1.png" alt="Tripidkard" width="100">
          </a>

          <!-- Toggle button aligned to the right -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <!-- Bootstrap classes for hiding text on smaller screens -->
            <span class="sr-only">Toggle navigation</span>
            <!-- Font Awesome icon for the toggle button -->
            <span class="navbar-toggler-icon" style="color: black;"></span>
          </button>

          <!-- Navigation links aligned to the right -->
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"> <!-- Add ml-auto class here -->
              <li class="nav-item active">
                <router-link class="nav-link text-dark text-uppercase" to="/tripidkard">Tripidkard</router-link>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark text-uppercase" href="/merchants">Merchant</a>
              </li>
              <li class="nav-item">
                <router-link class="nav-link text-dark text-uppercase" to="/join">How To Join</router-link>
              </li>

              <li class="nav-item">
                <router-link class="nav-link text-dark text-uppercase" to="/contact-us">Contact</router-link>
              </li>

              <li class="nav-item">
                <router-link class="nav-link  text-uppercase btn btn-primary font-weight-bold" style="font-size:13px;" to="/login">Merchant Login</router-link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </template>
