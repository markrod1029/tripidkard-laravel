<template>
    <!-- Floating Cart Icon -->
    <div @click="handleCart" class="floating-cart">
      <i class="fa fa-shopping-cart text-white"></i>
      <span class="cart-count">{{ cartCount }}</span>
    </div>
    <!-- End Floating Cart Icon -->
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const cartCount = ref(0);
const authStore = useAuthStore();
const router = useRouter();

const fetchCartCount = async () => {
  try {
    const response = await axios.get('/api/carts/count');
    cartCount.value = response.data.count;
  } catch (error) {
    console.error('Error fetching cart count:', error);
  }
};

const handleCart = () => {
  router.push({ name: 'merchant.order.cart' });
};

onMounted(() => {
  fetchCartCount();
});
</script>

<style scoped>
.floating-cart {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #1D85BD;
  color: white;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 1101; /* Ensure cart icon is above the footer */
}

.cart-count {
  position: absolute;
  top: -10px;
  right: -10px;
  background-color: red;
  color: white;
  border-radius: 50%;
  padding: 7px;
  font-size: 12px;
}
</style>
