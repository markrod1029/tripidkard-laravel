<template>
    <div class="small-box bg-default" style="background-color:white;">
        <div class="card-body">
            <center class="mt-4">
                <img id="imageResult" height="150" width="150"
                    src="<?php echo (!empty($user['photo'])) ? '../images/merchant/'.$user['photo'] : ' ../images/profile.jpg'; ?>"
                    class="img-circle " alt="User Image" >
                <h4 class="card-subtitle mt-2">
                    {{ authUser.users.fname }} {{ authUser.users.mname }} {{ authUser.users.lname }}
                </h4>
                <h5 class="card-subtitle">
                    {{ authUser.users.role }}

                </h5>
            </center>

        </div>
        <hr>
        <div class="card-body" style="margin-left:30px;">

            <small class="text-muted">Business Code</small>
            <h6>{{ authUser.users.business_code }} </h6>

            <small class="text-muted">Card Number</small>
            <h6>{{ authUser.users.card_code }} </h6>

            <small class="text-muted">Email address</small>
            <h6><a href="mailto:<?php echo $user['email']; ?>">{{ authUser.users.email }} </a></h6>

            <small class="text-muted pt-4 db">Phone</small>
            <h6><a href="tel:<?php echo $user['contact']; ?>">{{ authUser.users.contact }} </a></h6>

            <small class="text-muted">Address</small>
            <h6>{{ authUser.users.zip }} {{ authUser.users.street }} {{ authUser.users.city }} {{ authUser.users.province }}</h6>
        </div>
    </div>

</template>


<script setup>
import { useAuthUserStore } from '@/Stores/AuthUser';

const authUser = useAuthUserStore();
</script>
