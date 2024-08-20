<template>
    <div class="py-3 py-md-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="bg-white p-4 p-md-5 rounded shadow-lg">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-5">
                                    <h3 class="text-dark font-weight-bold">Customer Information</h3>
                                </div>
                            </div>
                        </div>

                        <div class="information">
                            <div class="info-group">
                                <label><strong>Name:</strong></label>
                                <span>{{ name }}</span>
                            </div>
                            <div class="info-group">
                                <label><strong>Card Number:</strong></label>
                                <span>{{ cardNumber }}</span>
                            </div>
                            <div class="info-group">
                                <label><strong>Email:</strong></label>
                                <span>{{ email }}</span>
                            </div>
                            <div class="info-group">
                                <label><strong>Validity:</strong></label>
                                <span>{{ validity }}</span>
                            </div>
                            <div class="info-group">
                                <label><strong>Loyalty Points:</strong></label>
                                <span>{{ loyaltyPoints }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const name = 'John Doe';
const cardNumber = '1234 5678 9012 3456';
const email = 'johndoe@example.com';
const validity = '12/2025';
const loyaltyPoints = '1500';
</script>

<style scoped>
.info-group {
    margin-bottom: 15px;
}

.info-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.info-group span {
    display: block;
    padding: 10px 15px;
    border-radius: 4px;
    background-color: #e9ecef;
    font-size: 16px;
    color: #495057;
}
</style>
