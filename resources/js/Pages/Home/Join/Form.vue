<template>

    <!-- Registration 1 - Bootstrap Brain Component -->
    <div class="bg-light py-3 py-md-5">
      <div class="container-fluid">
        <div class="row justify-content-center"><!-- Bagong class na idinagdag: justify-content-center -->
          <div class="col-12 col-md-8 col-lg-6">
            <div class="bg-white p-4 p-md-5 rounded shadow-sm">
              <div class="row">
                <div class="col-12">
                  <div class="text-center mb-5">
                    <a href="#!">
                      <img src="/storage/img/raffle.jpg" alt="BootstrapBrain Logo" width="175" height="57">
                    </a>
                  </div>
                </div>
              </div>
              <form action="#!">
                <div class="row gy-3"><!-- Bagong class na idinagdag: row gy-3 -->
                  <div class="col-12">
                    <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
                          <!-- SVG content -->
                        </svg>
                      </span>
                      <input type="text" class="form-control" name="firstName" id="firstName" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                          <!-- SVG content -->
                        </svg>
                      </span>
                      <input type="text" class="form-control" name="lastName" id="lastName" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                          <!-- SVG content -->
                        </svg>
                      </span>
                      <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                          <!-- SVG content -->
                        </svg>
                      </span>
                      <input type="password" class="form-control" name="password" id="password" value="" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" name="iAgree" id="iAgree" required>
                      <label class="form-check-label text-secondary" for="iAgree">
                        I agree to the <a href="#!" class="link-primary text-decoration-none">terms and conditions</a>
                      </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <button class="btn btn-primary btn-lg" type="submit">Sign Up</button>
                    </div>
                  </div>
                </div>
              </form>
              <div class="row">
                <div class="col-12">
                  <hr class="mt-5 mb-4 border-secondary-subtle">
                  <p class="m-0 text-secondary text-center">Already have an account? <a href="#!" class="link-primary text-decoration-none">Sign in</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </template>
