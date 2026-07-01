<template>
  <header class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-3 px-lg-4">
    <div class="container-fluid p-0">
      <span class="navbar-brand mb-0 h1">Loan Products Admin Panel</span>

      <div class="d-flex align-items-center gap-3 ms-auto">
        <div class="text-end d-none d-md-block">
          <div class="fw-semibold">{{ authState.user?.name || '-' }}</div>
          <small class="text-muted">{{ authState.user?.email || '' }}</small>
        </div>

        <button class="btn btn-outline-danger btn-sm" type="button" @click="$emit('logout')">
          Logout
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { authState } from '../services/auth';

defineEmits(['logout']);
</script>
