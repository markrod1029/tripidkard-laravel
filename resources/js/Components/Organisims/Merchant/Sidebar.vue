<script setup>
import { useAuthUserStore } from '../../../Stores/AuthUser';

const authUser = useAuthUserStore();
</script>

<template>
  <aside class="main-sidebar sidebar-dark-primary">
    <a href="home" class="brand-link " style="border-style:none; height:70px; ">
      <img src="https://tripidkard.com/wp-content/uploads/2023/10/cropped-tripid-card-ver.-2-1.png" alt=" Logo"
        class=" img-circle " style=" height:50px;  ">

      <span class="brand-text font-weight-light text-center">Tripidkard </span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <div class="user-panel d-flex">

        <div class="image" style="position:relative; right:10px;">
          <img
          :src="authUser.users.avatar ? authUser.users.avatar : 'https://via.placeholder.com/640x360'"
            class="img-circle elevation-2" alt="User Image" style="height:55px; width:55px; margin-top:10px">
        </div>

        <div class="info">
                    <a href="#" class="d-block mt-1 mb-0 text-white text-center font-size:16px;">{{ authUser.users.fname}} {{ authUser.users.mname}} {{ authUser.users.lname}}</a>
                    <a href="#" class="d-block text-white ml-2 font-size:16px; text-center mb-2">{{ authUser.users.role
                        }}</a>
                </div>

      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="header text-center brand-text  text-white">PERSONAL</li>


          <li class="nav-item">
            <router-link to="/merchant/dashboard" class="nav-link" active-class="active">
              <i class="nav-icon fa fa-tachometer"></i>
              <p>Dashboard</p>
            </router-link>
          </li>


          <li class="nav-item">
            <router-link to="/merchant/scanner" class="nav-link" active-class="active">
              <i class="nav-icon fa fa-qrcode"></i>
              <p>QR Code Scanner</p>
            </router-link>
          </li>





          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-coins"></i>
              <p>
                Order Card
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/merchant/loyalty-stars" active-class="active" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p> Order Cards List</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/merchant/orders" active-class="active" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order cards</p>
                </router-link>
              </li>
            </ul>
          </li>


          <li class="nav-item has-treeview ">
            <router-link to="#"  class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                TripidKard Code
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/merchant/tripidkard" active-class="active" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TripidKard List</p>
                </router-link>
              </li>
            </ul>
          </li>








          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customer Account
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/merchant/customer" active-class="active" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer List</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/merchant/customer/register" active-class="active" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer Register</p>
                </router-link>
              </li>
            </ul>
          </li>


          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-coins"></i>
              <p>
                Loyalty Stars
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/merchant/loyalty-stars" active-class="active" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p> Loyalty Stars List</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/merchant/loyalty-stars/register" active-class="active" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register Loyalty Stars</p>
                </router-link>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <router-link to="/merchant/activity-log" active-class="active" class="nav-link">
              <i class="nav-icon fa fa-coins"></i>
              <p>Activity Logs</p>
            </router-link>
          </li>



          <!-- <li class="nav-item">
            <a href="aboutus.php" class="nav-link">
              <i class="nav-icon fa fa-user-circle"></i>
              <p>About Us</p>
            </a>
          </li> -->
          <br>





        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

</template>


<style>
.main-sidebar {
  background-color: #367fa9;
  height: 100vh !important;
  margin-bottom: 100px;

}

.main-sidebar,
.main-sidebar::before {
  transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
  width: 290px;
  position: fixed !important;
  ;
}

.sidebar-mini .main-sidebar .nav-link,
.sidebar-mini-md .main-sidebar .nav-link,
.sidebar-mini-xs .main-sidebar .nav-link {
  width: calc(290px - 0.5rem* 2);
  transition: width ease-in-out 0.3s;
}


.layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*=navbar]) {
  background-color: #367fa9;

}

.layout-top-nav .wrapper .main-header .brand-image {
  margin-top: -1.5rem;
  margin-right: 1.2rem;
  height: 133px;
}


.main-header {
  -webkit-transition: width 0.3s ease-in-out;
  -o-transition: width 0.3s ease-in-out;
  transition: width 0.3s ease-in-out;
  height: 80px;
  font-size: 22px;
  line-height: 20px;
  text-align: center;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  padding: 0 15px;
  font-weight: 300;

}

.sidebar {
  height: calc(100% - (3.5rem + 1px));
  overflow-y: auto;
  padding-left: 0.5rem;
  padding-right: 0.5rem;
  padding-top: 0;
  background-color: #367fa9;
  height: 100vh;
  margin-bottom: 100px;
  font-size: large;
}

@media (min-width: 768px) {

  body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .content-wrapper,
  body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-footer,
  body:not(.sidebar-mini-md):not(.sidebar-mini-xs):not(.layout-top-nav) .main-header {
    transition: margin-left 0.3s ease-in-out;
    margin-left: 290px;
  }
}


.user-panel {
  background-image: url('https://tripidkard.com/wp-content/uploads/2023/11/bg.jpg');
  background-repeat: no-repeat;
  background-position: center;
  position: relative;
  /* background: url(../images/background.png) center no-repeat; */
  width: 100%;
  padding-top: 20px;
  padding-bottom: 20px;
  overflow: hidden;
  color: black;
  margin-top: 22px;

}


/* breadcrumb Title Page */



.content-header {
  position: relative;
  padding-top: 70px;
  padding-left: 0;
  padding-right: 0;
  padding-bottom: 10px;
  background-color: #F5F5F5;

}

.content-header>h1 {
  margin: 0;
  font-size: 15px;
}

.content-header>h1>small {
  display: inline-block;
  font-weight: 300;
  padding-left: 110px;

}

.content-header>.breadcrumb {
  padding-left: 10px;
  background: transparent;
  margin-top: 0;
  margin-bottom: 0;
  font-size: 12px;
  padding: 7px 5px;
  position: absolute;
  top: 15px;
  right: 10px;
  border-radius: 2px;
}

.breadcrumb {
  list-style: none;
  border-radius: 4px;
  background-color: white;
  padding-top: 0;
}


.add {
  position: absolute;
  top: 20px;
  right: 20px;
}

.dashboard {
  padding-left: 20px;
  font-size: 24px;
}

.content-header>.breadcrumb>li>a {
  text-decoration: none;
  display: inline-block;
}

.content-header>.breadcrumb>li>a>.fa,
.content-header>.breadcrumb>li>a>.glyphicon,
.content-header>.breadcrumb>li>a>.ion {
  margin-right: 5px;
}

.content-header>.breadcrumb>li+li:before {
  content: '>\00a0';
}

@media (max-width: 991px) {
  .content-header {
    position: relative;
    padding-top: 110px;
    padding-left: 0;
    padding-right: 0;

  }

  .content-header>.breadcrumb {
    position: relative;
    margin-top: 5px;
    top: 0;
    right: 0;
    float: none;
    background: #d2d6de;
    padding-left: 10px;
  }

  .content-header>.breadcrumb li:before {
    color: #97a0b3;
  }
}


/* sidebar Active */
.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
.sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
  background-color: #222D32;
  color: #fff;
}

[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active,
[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus,
[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
  background-color: #222D32;
  color: #fff;
}
</style>

<!-- <style>
@media (max-width: 667px){
.input-group label {
    text-align: left;
    width: 100%;
    margin-bottom: 5px;
    text-align: left !important;
}
}










.user-panel .info {
  display: inline-block;
  padding:0;
}


.con{
  height: 500px;
  overflow-y: auto;
  overflow-x: hidden;
  margin-top:20px;
}
.con::-webkit-scrollbar-track
{
	background-color:#367FA9;
  height:10px;

}
.con:hover::-webkit-scrollbar
{
  display: block;
  height:10px;

}
.con::-webkit-scrollbar
{
	width: 6px;
	background-color: #367FA9;
  display:none;
  height:10px;


}

.con::-webkit-scrollbar-thumb
{
	background-color: #C1C7AB;

}



    </style> -->
