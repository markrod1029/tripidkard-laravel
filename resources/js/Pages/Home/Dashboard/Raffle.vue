<template>
    <!-- Boxes with images and text -->
    <div class="container mt-5">
        <h2 class="text-center mb-4 font-weight-bold" style="font-size: 2.3rem;">Join The Fun</h2>

    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4 mb-5">
                <div class="box position-relative">
                    <div class="box-overlay"></div>
                    <img src="/storage/img/raffle.jpg" alt="Box Image" class="img-fluid">
                    <div
                        class="box-content text-center text-white position-absolute w-100 h-100 d-flex flex-column justify-content-center">
                        <h3 class="mb-3 font-weight-bold">Join The Raffle</h3>
                        <a href="#" class="btn btn-light font-weight-bold align-self-center text-capitalize px-5">Join Now</a>

                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="box position-relative">
                    <div class="box-overlay"></div>
                    <img src="/storage/img/points.jpg" alt="Box Image" class="img-fluid">
                    <div
                        class="box-content text-center text-white position-absolute w-100 h-100 d-flex flex-column justify-content-center">
                        <h3 class="mb-3 font-weight-bold">loyalty Stars</h3>
                        <a href="#" class="btn btn-light font-weight-bold align-self-center text-capitalize px-5">Join Now</a>

                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="box position-relative">
                    <div class="box-overlay"></div>
                    <img src="/storage/img/event.jpg" alt="Box Image" class="img-fluid">
                    <div
                        class="box-content text-center text-white position-absolute w-100 h-100 d-flex flex-column justify-content-center">
                        <h3 class="mb-3 font-weight-bold">Upcoming Events</h3>
                        <a href="#" class="btn btn-light font-weight-bold align-self-center text-capitalize px-5">Join Now</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your page content goes here -->
</template>

<style scoped>
.container,
.title {
    font-size: 45px;
}

/* Overlay styles */
.box-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

/* Box styles */
.box {
    overflow: hidden;
    position: relative;
    height: 500px;
    /* Adjust height as needed */
}

.box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.box-content {
    position: absolute;
    top: 80%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}
</style>

<script>
export default {
    data() {
        return {
            // You can remove the images data since they're not used anymore
        };
    },
}
</script>
