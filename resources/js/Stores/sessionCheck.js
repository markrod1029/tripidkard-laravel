// sessionCheck.js
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default function checkSession() {
  const router = useRouter();

  onMounted(() => {
    // Tignan ang session
    const role = localStorage.getItem('role');
    if (role) {
      // I-redirect base sa role
      if (role === 'Admin') {
        router.push('/admin/dashboard');
      } else if (role === 'Merchant') {
        router.push('/merchant/dashboard');
      } else if (role === 'Enterprise') {
        router.push('/enterprise/dashboard');
      }
    }
  });
}
