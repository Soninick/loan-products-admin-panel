<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-7 col-lg-5">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4 p-md-5">
            <h1 class="h4 mb-3">Login</h1>
            <p class="text-muted mb-4">Use your admin or viewer credentials to continue.</p>

            <Alert v-if="errorMessage" :message="errorMessage" @close="errorMessage = ''" />

            <form @submit.prevent="handleLogin">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input v-model="form.email" type="email" class="form-control" required />
              </div>

              <div class="mb-3">
                <label class="form-label">Password</label>
                <input v-model="form.password" type="password" class="form-control" required />
              </div>

              <button class="btn btn-primary w-100" type="submit" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm me-2" />
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import Alert from '../components/Alert.vue';
import { loginRequest } from '../api';
import { storeAuthSession } from '../services/auth';

const router = useRouter();
const loading = ref(false);
const errorMessage = ref('');

const form = reactive({
  email: '',
  password: '',
});

async function handleLogin() {
  loading.value = true;
  errorMessage.value = '';

  try {
    const response = await loginRequest(form);
    const authData = response.data.data;

    storeAuthSession(authData.access_token, authData.user);
    router.push({ name: 'dashboard' });
  } catch (error) {
    errorMessage.value = error?.response?.data?.message || 'Unable to login.';
  } finally {
    loading.value = false;
  }
}
</script>
