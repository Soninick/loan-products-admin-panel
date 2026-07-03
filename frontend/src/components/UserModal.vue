<template>
  <div v-if="show">
    <div class="modal fade show d-block" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add User</h5>
            <button type="button" class="btn-close" @click="$emit('close')" />
          </div>

          <form @submit.prevent="handleSubmit" autocomplete="off">
            <div class="modal-body">
              <Alert
                v-if="errorMessage"
                :message="errorMessage"
                @close="$emit('clear-error')"
              />

              <div class="row g-3">

                <div class="col-md-6">
                  <label class="form-label">Name</label>
                  <input
                    v-model.trim="form.name"
                    type="text"
                    class="form-control"
                    placeholder="Enter full name"
                    required
                  />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input
                    v-model.trim="form.email"
                    type="email"
                    class="form-control"
                    placeholder="Enter email address"
                    autocomplete="off"
                    required
                  />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Password</label>
                  <input
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    placeholder="Enter password"
                    autocomplete="new-password"
                    required
                  />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Role</label>
                  <select
                    v-model.number="form.role_id"
                    class="form-select"
                    required
                  >
                    <option :value="1">Admin</option>
                    <option :value="2">Viewer</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Date of Birth</label>
                  <input
                    v-model="form.dob"
                    type="date"
                    class="form-control"
                    required
                  />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Credit Score</label>
                  <input
                    v-model.number="form.credit_score"
                    type="number"
                    class="form-control"
                    placeholder="Enter credit score"
                    min="300"
                    max="900"
                    required
                  />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Employment Type</label>
                  <select
                    v-model="form.employment_type"
                    class="form-select"
                    required
                  >
                    <option value="Salaried">Salaried</option>
                    <option value="Self Employed">Self Employed</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Salary Type</label>
                  <select
                    v-model="form.salary_type"
                    class="form-select"
                    required
                  >
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Salary</label>
                  <input
                    v-model.number="form.salary"
                    type="number"
                    class="form-control"
                    placeholder="Enter salary"
                    min="0"
                    required
                  />
                </div>

              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                @click="$emit('close')"
              >
                Cancel
              </button>

              <button
                type="submit"
                class="btn btn-primary"
              >
                Save User
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <div class="modal-backdrop fade show modal-backdrop-custom"></div>
  </div>
</template>

<script setup>
import { reactive, watch } from 'vue';
import Alert from './Alert.vue';

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  errorMessage: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['close', 'save', 'clear-error']);

const getDefaultForm = () => ({
  name: '',
  email: '',
  password: '',
  role_id: 2,
  dob: '',
  credit_score: '',
  employment_type: 'Salaried',
  salary_type: 'Monthly',
  salary: '',
});

const form = reactive(getDefaultForm());

watch(
  () => props.show,
  (visible) => {
    if (visible) {
      Object.assign(form, getDefaultForm());
    }
  }
);

function handleSubmit() {
  emit('save', {
    name: form.name,
    email: form.email,
    password: form.password,
    role_id: Number(form.role_id),
    dob: form.dob,
    credit_score: Number(form.credit_score),
    employment_type: form.employment_type,
    salary_type: form.salary_type,
    salary: Number(form.salary),
  });
}
</script>