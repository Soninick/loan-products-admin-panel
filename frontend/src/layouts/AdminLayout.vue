<template>
  <div class="app-shell d-flex">
    <Sidebar />

    <div class="flex-grow-1 content-area">
      <Navbar @logout="handleLogout" />

      <main class="p-3 p-lg-4">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<script setup>
import { useRouter, RouterView } from 'vue-router';
import Sidebar from '../components/Sidebar.vue';
import Navbar from '../components/Navbar.vue';
import { clearAuthSession } from '../services/auth';
import { logoutRequest } from '../api';

const router = useRouter();

async function handleLogout() {
  try {
    await logoutRequest();
  } catch {
    // ignore logout API failures and clear the local session
  } finally {
    clearAuthSession();
    router.push({ name: 'login' });
  }
}
</script>
