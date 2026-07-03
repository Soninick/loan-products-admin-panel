<template>
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <h1 class="h5 mb-0">Users</h1>
      <button v-if="isAdmin" type="button" class="btn btn-primary btn-sm" @click="showUserModal = true">
        Add User
      </button>
    </div>

    <div class="card-body">
      <Alert v-if="message" :message="message" variant="success" @close="message = ''" />
      <Alert v-if="errorMessage" :message="errorMessage" @close="errorMessage = ''" />
      <Loader v-if="loading" />

      <div v-else class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Credit Score</th>
              <th>Employment</th>
              <th>Salary Type</th>
              <th>Salary</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.name }}</td>
              <td>{{ user.credit_score }}</td>
              <td>{{ user.employment_type }}</td>
              <td>{{ user.salary_type }}</td>
              <td>{{ formatMoney(user.salary) }}</td>
              <td>
                <span :class="['badge', user.status === 'Active' ? 'bg-success' : 'bg-secondary']">
                  {{ user.status }}
                </span>
              </td>
              <td class="text-end">
                <button type="button" class="btn btn-outline-primary btn-sm" @click="viewEligibleProducts(user)">
                  View Eligible Products
                </button>
              </td>
            </tr>
            <tr v-if="users.length === 0">
              <td colspan="7" class="text-center text-muted py-4">No users found.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <UserModal
    :show="showUserModal"
    :error-message="modalError"
    @close="closeUserModal"
    @clear-error="modalError = ''"
    @save="handleCreateUser"
  />
  <EligibleProductsModal
    :show="showEligibleProductsModal"
    :eligible-products="eligibleProducts"
    @close="closeEligibleModal"
  />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import Alert from '../components/Alert.vue';
import Loader from '../components/Loader.vue';
import UserModal from '../components/UserModal.vue';
import EligibleProductsModal from '../components/EligibleProductsModal.vue';
import { authState } from '../services/auth';
import { createUserRequest, getEligibleProductsRequest, getUsersRequest } from '../api';
import { formatMoney } from '../utils/format';

const users = ref([]);
const loading = ref(false);
const errorMessage = ref('');
const message = ref('');
const showUserModal = ref(false);
const showEligibleProductsModal = ref(false);
const eligibleProducts = ref([]);
const modalError = ref('');

const isAdmin = computed(() => authState.user?.role?.name === 'Admin');

async function loadUsers() {
  loading.value = true;
  errorMessage.value = '';

  try {
    const response = await getUsersRequest();
    users.value = response.data.data || [];
  } catch {
    errorMessage.value = 'Unable to load users.';
  } finally {
    loading.value = false;
  }
}

async function handleCreateUser(payload) {
  try {
    await createUserRequest(payload);
    message.value = 'User created successfully.';
    showUserModal.value = false;
    modalError.value = '';
    await loadUsers();
  } catch (error) {
    const errors = error?.response?.data?.errors;

    if (errors && typeof errors === 'object') {
      const firstField = Object.keys(errors)[0];

      if (firstField && Array.isArray(errors[firstField]) && errors[firstField].length > 0) {
        modalError.value = errors[firstField][0];
        return;
      }
    }

    modalError.value = error?.response?.data?.message || 'Unable to save user.';
  }
}

function closeUserModal() {
  showUserModal.value = false;
  modalError.value = '';
}

async function viewEligibleProducts(user) {
  try {
    const response = await getEligibleProductsRequest(user.id);
    eligibleProducts.value = response.data.data || [];
    showEligibleProductsModal.value = true;
  } catch {
    errorMessage.value = 'Unable to load eligible products.';
  }
}

function closeEligibleModal() {
  showEligibleProductsModal.value = false;
  eligibleProducts.value = [];
}

onMounted(loadUsers);
</script>
