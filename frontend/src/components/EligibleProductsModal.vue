<template>
  <div v-if="show">
    <div class="modal fade show d-block" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Eligible Products</h5>
            <button type="button" class="btn-close" @click="$emit('close')" />
          </div>

          <div class="modal-body">
            <div v-if="eligibleProducts.length === 0" class="text-muted">
              No eligible products found.
            </div>

            <div v-else class="table-responsive">
              <table class="table table-sm table-bordered align-middle mb-0">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Age</th>
                    <th>Credit Score</th>
                    <th>Employment Types</th>
                    <th>Salary Types</th>
                    <th>Minimum Salary</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in eligibleProducts" :key="item.id">
                    <td>{{ item.product?.name }}</td>
                    <td>{{ item.product?.min_age }} - {{ item.product?.max_age }}</td>
                    <td>{{ item.product?.min_credit_score }}</td>
                    <td>{{ formatList(item.product?.allowed_employment_types) }}</td>
                    <td>{{ formatList(item.product?.allowed_salary_types) }}</td>
                    <td>{{ formatMoney(item.product?.min_salary) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-light" @click="$emit('close')">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show modal-backdrop-custom" />
  </div>
</template>

<script setup>
import { formatList, formatMoney } from '../utils/format';

defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  eligibleProducts: {
    type: Array,
    default: () => [],
  },
});

defineEmits(['close']);
</script>
