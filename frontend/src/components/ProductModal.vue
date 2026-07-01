<template>
  <div v-if="show">
    <div class="modal fade show d-block" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ isEdit ? 'Edit Product' : 'Add Product' }}</h5>
            <button type="button" class="btn-close" @click="$emit('close')" />
          </div>

          <form @submit.prevent="handleSubmit">
            <div class="modal-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Name</label>
                  <input v-model="form.name" type="text" class="form-control" required />
                </div>
                <div class="col-12">
                  <label class="form-label">Description</label>
                  <textarea v-model="form.description" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Minimum Age</label>
                  <input v-model="form.min_age" type="number" class="form-control" required />
                </div>
                <div class="col-md-4">
                  <label class="form-label">Maximum Age</label>
                  <input v-model="form.max_age" type="number" class="form-control" required />
                </div>
                <div class="col-md-4">
                  <label class="form-label">Minimum Credit Score</label>
                  <input v-model="form.min_credit_score" type="number" class="form-control" required />
                </div>
                <div class="col-12">
                  <label class="form-label">Allowed Employment Types</label>
                  <input
                    v-model="form.allowed_employment_types"
                    type="text"
                    class="form-control"
                    placeholder="Salaried, Self Employed"
                    required
                  />
                </div>
                <div class="col-12">
                  <label class="form-label">Allowed Salary Types</label>
                  <input
                    v-model="form.allowed_salary_types"
                    type="text"
                    class="form-control"
                    placeholder="Monthly, Yearly"
                    required
                  />
                </div>
                <div class="col-md-4">
                  <label class="form-label">Minimum Salary</label>
                  <input v-model="form.min_salary" type="number" step="0.01" class="form-control" required />
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-light" @click="$emit('close')">Cancel</button>
              <button type="submit" class="btn btn-primary">{{ isEdit ? 'Update' : 'Save' }}</button>
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

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  product: {
    type: Object,
    default: null,
  },
});

const emit = defineEmits(['close', 'save']);

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
    name: form.name.trim(),
    description: form.description.trim() || null,
    min_age: Number(form.min_age),
    max_age: Number(form.max_age),
    min_credit_score: Number(form.min_credit_score),
    allowed_employment_types: form.allowed_employment_types
      .split(',')
      .map((item) => item.trim())
      .filter(Boolean),
    allowed_salary_types: form.allowed_salary_types
      .split(',')
      .map((item) => item.trim())
      .filter(Boolean),
    min_salary: Number(form.min_salary),
  });
}
</script>
