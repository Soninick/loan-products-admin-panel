<template>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-4">
      <h1 class="h4 mb-2">Dashboard</h1>
      <p class="text-muted mb-0">
        Welcome back, {{ authState.user?.name || 'User' }}.
      </p>
    </div>
  </div>
</template>

<script setup>
import { authState } from '../services/auth';
</script>
