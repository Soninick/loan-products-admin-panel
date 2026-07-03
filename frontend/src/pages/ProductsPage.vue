<template>
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <h1 class="h5 mb-0">Products</h1>
      <button v-if="isAdmin" type="button" class="btn btn-primary btn-sm" @click="openCreateModal">
        Add Product
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
              <th>Minimum Age</th>
              <th>Maximum Age</th>
              <th>Minimum Credit Score</th>
              <th>Employment Types</th>
              <th>Salary Types</th>
              <th>Minimum Salary</th>
              <th v-if="isAdmin" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" :key="product.id">
              <td>
                <div class="fw-semibold">{{ product.name }}</div>
                <small class="text-muted">{{ product.description || '-' }}</small>
              </td>
              <td>{{ product.min_age }}</td>
              <td>{{ product.max_age }}</td>
              <td>{{ product.min_credit_score }}</td>
              <td>{{ formatList(product.allowed_employment_types) }}</td>
              <td>{{ formatList(product.allowed_salary_types) }}</td>
              <td>{{ formatMoney(product.min_salary) }}</td>
              <td v-if="isAdmin" class="text-end">
                <button type="button" class="btn btn-outline-secondary btn-sm" @click="openEditModal(product)">
                  Edit
                </button>
              </td>
            </tr>
            <tr v-if="products.length === 0">
              <td :colspan="isAdmin ? 8 : 7" class="text-center text-muted py-4">
                No products found.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <ProductModal
    :show="showModal"
    :product="selectedProduct"
    :error-message="modalError"
    @close="closeModal"
    @clear-error="modalError = ''"
    @save="handleSave"
  />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import Alert from '../components/Alert.vue';
import Loader from '../components/Loader.vue';
import ProductModal from '../components/ProductModal.vue';
import { createProductRequest, getProductsRequest, updateProductRequest } from '../api';
import { authState } from '../services/auth';
import { formatList, formatMoney } from '../utils/format';

const products = ref([]);
const loading = ref(false);
const errorMessage = ref('');
const message = ref('');
const showModal = ref(false);
const selectedProduct = ref(null);
const modalError = ref('');

const isAdmin = computed(() => authState.user?.role?.name === 'Admin');

async function loadProducts() {
  loading.value = true;
  errorMessage.value = '';

  try {
    const response = await getProductsRequest();
    products.value = response.data.data || [];
  } catch {
    errorMessage.value = 'Unable to load products.';
  } finally {
    loading.value = false;
  }
}

function openCreateModal() {
  selectedProduct.value = null;
  modalError.value = '';
  showModal.value = true;
}

function openEditModal(product) {
  selectedProduct.value = product;
  modalError.value = '';
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  selectedProduct.value = null;
  modalError.value = '';
}

function getValidationMessage(error, fallbackMessage) {
  const errors = error?.response?.data?.errors;

  if (errors && typeof errors === 'object') {
    const firstField = Object.keys(errors)[0];

    if (firstField && Array.isArray(errors[firstField]) && errors[firstField].length > 0) {
      return errors[firstField][0];
    }
  }

  return error?.response?.data?.message || fallbackMessage;
}

async function handleSave(payload) {
  try {
    if (selectedProduct.value) {
      await updateProductRequest(selectedProduct.value.id, payload);
      message.value = 'Product updated successfully.';
    } else {
      await createProductRequest(payload);
      message.value = 'Product created successfully.';
    }

    closeModal();
    await loadProducts();
  } catch (error) {
    modalError.value = getValidationMessage(error, 'Unable to save product.');
  }
}

onMounted(loadProducts);
</script>
