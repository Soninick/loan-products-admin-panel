<template>
  <div v-if="show">
    <div class="modal fade show d-block" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add User</h5>
            <button type="button" class="btn-close" @click="$emit('close')" />
          </div>

          <form @submit.prevent="handleSubmit">
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Name</label>
                  <input v-model="form.name" type="text" class="form-control" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input v-model="form.email" type="email" class="form-control" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Password</label>
                  <input v-model="form.password" type="password" class="form-control" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Role</label>
                  <select v-model.number="form.role_id" class="form-select" required>
                    <option :value="1">Admin</option>
                    <option :value="2">Viewer</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Date of Birth</label>
                  <input v-model="form.dob" type="date" class="form-control" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Credit Score</label>
                  <input v-model="form.credit_score" type="number" class="form-control" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Employment Type</label>
                  <input v-model="form.employment_type" type="text" class="form-control" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Salary Type</label>
                  <input v-model="form.salary_type" type="text" class="form-control" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Salary</label>
                  <input v-model="form.salary" type="number" step="0.01" class="form-control" required />
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-light" @click="$emit('close')">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show modal-backdrop-custom" />
  </div>
</template>

<script setup>
import { reactive, watch } from 'vue';

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['close', 'save']);

const form = reactive({
  name: '',
  email: '',
  password: '',
  role_id: 2,
  dob: '',
  credit_score: '',
  employment_type: '',
  salary_type: '',
  salary: '',
});

watch(
  () => props.show,
  (visible) => {
    if (visible) {
      form.name = '';
      form.email = '';
      form.password = '';
      form.role_id = 2;
      form.dob = '';
      form.credit_score = '';
      form.employment_type = '';
      form.salary_type = '';
      form.salary = '';
    }
  },
);

function handleSubmit() {
  emit('save', {
    name: form.name.trim(),
    email: form.email.trim(),
    password: form.password,
    role_id: Number(form.role_id),
    dob: form.dob,
    credit_score: Number(form.credit_score),
    employment_type: form.employment_type.trim(),
    salary_type: form.salary_type.trim(),
    salary: Number(form.salary),
  });
}
</script>
