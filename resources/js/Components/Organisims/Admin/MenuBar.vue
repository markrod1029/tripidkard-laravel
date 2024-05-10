<template>


<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
        <form class="form-inline">
        <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
        <i class="fas fa-search"></i>
        </button>
        <button class="btn btn-navbar" type="button" data-widget="navbar-search">
        <i class="fas fa-times"></i>
        </button>
        </div>
        </div>
        </form>
        </div>
        </li> -->



        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-cogs dark"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    <span class="dropdown-header">Settings</span>
                        <div class="dropdown-divider"></div>


                        <a class="border-top dropdown-item " ></a>
                    <a href="/merchant/profile" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i>  Profile Settings
                    </a>

                    <a onclick="return confirm('Are you sure To Log Out')" href="../classes/logout.php" class="dropdown-item">
                        <i class="fa fa-power-off mr-2"></i> Logout
                    </a>

                <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
            </div>
        </li>

        <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
        </a>
        </li>

    </ul>
</nav>

    <!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars "></i></a>
            </li>
        </ul>

        <ul class="navbar-nav1 mr-auto">
            <li class="nav-item dropdown">

                <a class="nav-link" data-toggle="dropdown" id="main-sidebar" href="#">
                    <center>
                        <i class="fa fa-cogs text-white"> </i>
                    </center>
                </a>

                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <a class=" dropdown-item " style="margin-bottom" href="profile.php">
                        <i class="fa fa-cogs dark"> </i>  Profile Settings</a>
                        <a class="border-top dropdown-item " onclick="return confirm('Are you sure To Log Out')" href="../classes/logout.php" ><i class="fa fa-power-off dark"></i> Logout</a>
                    </div>
            </li>
        </ul>
    </nav> -->

</template>

<!--
<style>


body {

display: block;
margin: 0 !important;
}
/*
@media screen and (min-width: 0px) and (max-width: 700px) {
  .hide {


}
} */

@media screen and (min-width: 701px) {
.fa-bars {
position: absolute;
top: 30px;
display: block;
}
}

@media screen and (max-width: 1024px) {
.fa-bars {
position: absolute;
top: 100px;
display: block;
}
}


.navbar-nav1 {
  float:right;
display: -ms-flexbox;
display: flex;
-ms-flex-direction: column;
flex-direction: column;
padding-left: 0;
margin-bottom: 0;
margin-top: -30px;
list-style: none;
}

.hide {
display: -ms-flexbox;
display: flex;
-ms-flex-direction: column;
flex-direction: column;
padding-left: 0;
margin-bottom: 0;
list-style: none;

}
.content-header {
position: relative;
padding-top: 30px;
padding-bottom:30px;
margin-bottom:80px;

}
.content-header > h1 {
margin: 0;
font-size: 15px;
}
.content-header > h1 > small {
display: inline-block;
font-weight: 300;
padding-left: 110px;

}
.content-header > .breadcrumb {
padding-left: 10px;
background: transparent;
margin-top: 0;
margin-bottom: 0;
font-size: 12px;
padding: 7px 5px;
position: absolute;
right: 10px;
border-radius: 2px;
top:0;
}
.breadcrumb {
list-style: none;
border-radius: 4px;
background-color:white;
margin-left:20px;
}


.add{
position:absolute;
top:1120px;
right: 60px;
}
.dashboard{
padding-left: 20px;
font-size:24px;
}
.content-header > .breadcrumb > li > a {
text-decoration: none;
display: inline-block;
}
.content-header > .breadcrumb > li > a > .fa,
.content-header > .breadcrumb > li > a > .glyphicon,
.content-header > .breadcrumb > li > a > .ion {
margin-right: 5px;
}
.content-header > .breadcrumb > li + li:before {
content: '>\00a0';
}
@media (max-width: 691px) {
.content-header {
position: relative;
padding-top: 110px;
padding-left: 0;
padding-right: 0;


}
.content-header > .breadcrumb {
position: relative;
margin-top: 5px;
top: 0;
right: 0;
float: none;
background: #d2d6de;
padding-left: 10px;
}
.content-header > .breadcrumb li:before {
color: #97a0b3;
}

.content-wrapper>.content {
position: relative;
top:-36px;
}

}

.content {
min-height: 420px;
padding: 15px;
margin-right: auto;
margin-left: auto;
padding-left: 15px;
padding-right: 15px;
}


</style> -->
