<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-cogs dark"></i>
          </a>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">Settings</span>
            <div class="dropdown-divider"></div>

            <!-- Conditionally display based on user role -->
            <a v-if="role === 'Admin'" href="/admin/profile" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile Settings
            </a>
            <a v-if="role === 'Merchant'" href="/merchant/profile" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile Settings
            </a>
            <a v-if="role === 'Influencer'" href="/influencer/profile" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile Settings
            </a>

            <a @click.prevent="handleLogout" class="dropdown-item">
              <i class="fa fa-power-off mr-2"></i> Logout
            </a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
  </template>

  <script setup>
  import { useRouter } from 'vue-router';
  import { useAuthStore } from '@/Stores/auth';
  import { ref, onMounted } from 'vue';

  // Initialize auth store and router
  const authStore = useAuthStore();
  const router = useRouter();

  // Store the user's role in a ref
  const role = ref('');

  // Fetch the user role on component mount
  onMounted(async () => {
    await authStore.getUser(); // Ensure user data is loaded
    role.value = authStore.user.role; // Assuming `user.role` contains the role
  });

  // Handle logout
  const handleLogout = async () => {
    const confirmLogout = confirm("Are you sure you want to log out?");
    if (confirmLogout) {
      await authStore.logout();
      router.push('/login'); // Redirect to login page after logout
    }
  };
  </script>
