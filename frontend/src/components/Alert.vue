<template>
  <div :class="['alert', `alert-${variant}`, 'd-flex', 'justify-content-between', 'align-items-center']" role="alert">
    <div>{{ message }}</div>
    <button v-if="dismissible" type="button" class="btn-close" aria-label="Close" @click="$emit('close')" />
  </div>
</template>

<script setup>
defineProps({
  message: {
    type: String,
    required: true,
  },
  variant: {
    type: String,
    default: 'danger',
  },
  dismissible: {
    type: Boolean,
    default: true,
  },
});

defineEmits(['close']);
</script>
