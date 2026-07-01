<template>
  <aside class="sidebar bg-dark text-white min-vh-100 d-none d-lg-flex flex-column p-3">
    <div class="mb-4">
      <h5 class="mb-1">Loan Admin</h5>
      <small class="text-white-50">{{ authState.user?.role?.name || 'User' }}</small>
    </div>

    <nav class="nav nav-pills flex-column gap-2">
      <RouterLink class="nav-link text-white" active-class="active" :to="{ name: 'dashboard' }">
        Dashboard
      </RouterLink>
      <RouterLink class="nav-link text-white" active-class="active" :to="{ name: 'products' }">
        Products
      </RouterLink>
      <RouterLink class="nav-link text-white" active-class="active" :to="{ name: 'users' }">
        Users
      </RouterLink>
    </nav>
  </aside>
</template>

<script setup>
import { RouterLink } from 'vue-router';
import { authState } from '../services/auth';
</script>
