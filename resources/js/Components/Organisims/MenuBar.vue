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

                    <a class="border-top dropdown-item"></a>
                    <a href="/merchant/profile" class="dropdown-item">
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

    const authStore = useAuthStore();
    const router = useRouter();

    const handleLogout = async () => {
        const confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
            await authStore.logout();
            router.push('/login'); // Redirect to login page after logout
        }
    };
    </script>
