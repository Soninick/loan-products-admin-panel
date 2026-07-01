<template>
  <div class="container py-5">
    <div class="text-center">
      <h1 class="display-6 fw-semibold">404</h1>
      <p class="text-muted">The page you are looking for does not exist.</p>
      <RouterLink class="btn btn-primary" :to="{ name: 'dashboard' }">Go to Dashboard</RouterLink>
    </div>
  </div>
</template>

<script setup>
import { RouterLink } from 'vue-router';
</script>
