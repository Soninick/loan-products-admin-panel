<template>
  <div v-if="show">
    <div class="modal fade show d-block" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ isEdit ? 'Edit Product' : 'Add Product' }}</h5>
            <button type="button" class="btn-close" @click="$emit('close')" />
          </div>

          <form @submit.prevent="handleSubmit" autocomplete="off">
            <div class="modal-body">
              <Alert v-if="errorMessage" :message="errorMessage" @close="$emit('clear-error')" />

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Name</label>
                  <input
                    v-model.trim="form.name"
                    type="text"
                    class="form-control"
                    placeholder="Enter product name"
                    required
                  />
                </div>
                <div class="col-12">
                  <label class="form-label">Description</label>
                  <textarea
                    v-model.trim="form.description"
                    class="form-control"
                    rows="3"
                    placeholder="Enter product description"
                  ></textarea>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Minimum Age</label>
                  <input
                    v-model.number="form.min_age"
                    type="number"
                    class="form-control"
                    placeholder="21"
                    min="18"
                    required
                  />                
                </div>
                <div class="col-md-4">
                  <label class="form-label">Maximum Age</label>
                <input
                  v-model.number="form.max_age"
                  type="number"
                  class="form-control"
                  placeholder="58"
                  max="100"
                  required
                />
                </div>
                <div class="col-md-4">
                  <label class="form-label">Minimum Credit Score</label>
                <input
                  v-model.number="form.min_credit_score"
                  type="number"
                  class="form-control"
                  placeholder="700"
                  min="300"
                  max="900"
                  required
                />
                </div>
                <div class="col-12">
                  <label class="form-label">Allowed Employment Types</label>
                  <input
                    v-model="form.allowed_employment_types"
                    type="text"
                    class="form-control"
                    placeholder="e.g. Salaried, Self Employed"
                    required
                  />
                </div>
                <div class="col-12">
                  <label class="form-label">Allowed Salary Types</label>
                  <input
                    v-model="form.allowed_salary_types"
                    type="text"
                    class="form-control"
                    placeholder="e.g. Monthly, Yearly"
                    required
                  />
                </div>
                <div class="col-md-4">
                  <label class="form-label">Minimum Salary</label>
                <input
                  v-model.number="form.min_salary"
                  type="number"
                  class="form-control"
                  placeholder="25000"
                  min="0"
                  required
                />               
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-light" @click="$emit('close')">Cancel</button>
              <button type="submit" class="btn btn-primary">
                {{ isEdit ? 'Update Product' : 'Save Product' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show modal-backdrop-custom" />
  </div>
</template>

<script setup>
import { computed, reactive, watch } from 'vue';
import Alert from './Alert.vue';

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  product: {
    type: Object,
    default: null,
  },
  errorMessage: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['close', 'save', 'clear-error']);

const form = reactive({
  name: '',
  description: '',
  min_age: '',
  max_age: '',
  min_credit_score: '',
  allowed_employment_types: '',
  allowed_salary_types: '',
  min_salary: '',
});

const isEdit = computed(() => Boolean(props.product));

function resetForm() {
  form.name = props.product?.name || '';
  form.description = props.product?.description || '';
  form.min_age = props.product?.min_age ?? '';
  form.max_age = props.product?.max_age ?? '';
  form.min_credit_score = props.product?.min_credit_score ?? '';
  form.allowed_employment_types = Array.isArray(props.product?.allowed_employment_types)
    ? props.product.allowed_employment_types.join(', ')
    : '';
  form.allowed_salary_types = Array.isArray(props.product?.allowed_salary_types)
    ? props.product.allowed_salary_types.join(', ')
    : '';
  form.min_salary = props.product?.min_salary ?? '';
}

watch(
  () => props.show,
  (visible) => {
    if (visible) {
      resetForm();
    }
  },
);

function handleSubmit() {
  emit('save', {
    name: form.name,
    description: form.description || null,
    min_age: form.min_age,
    max_age: form.max_age,
    min_credit_score: form.min_credit_score,
    allowed_employment_types: form.allowed_employment_types
      .split(',')
      .map(item => item.trim())
      .filter(Boolean),
    allowed_salary_types: form.allowed_salary_types
      .split(',')
      .map(item => item.trim())
      .filter(Boolean),
    min_salary: form.min_salary,
  });
}
</script>
