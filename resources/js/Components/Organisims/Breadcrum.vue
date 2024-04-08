<template>
    <Section class="content-header mb-5">

        <div class="card" style="position:absolute; top:0; width:100%; padding:20px 0 20px 0; border-top-color: black;">
            <h1 class="dashboard">{{ $route.meta.title }}</h1>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li><a href="/admin/dashboard"><i class="fas fa-dashboard"> &nbsp;</i>Home &nbsp;</a> </li>
                    <li class="breadcrumb-item active"> /&nbsp;{{ $route.meta.title }}</li>
                </ol>
            </div>
        </div>
    </section>

</template>

<script setup>

</script>