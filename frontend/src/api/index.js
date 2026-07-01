import api from './client';

export function loginRequest(payload) {
  return api.post('/login', payload);
}

export function logoutRequest() {
  return api.post('/logout');
}

export function meRequest() {
  return api.get('/me');
}

export function getProductsRequest() {
  return api.get('/products');
}

export function createProductRequest(payload) {
  return api.post('/products', payload);
}

export function updateProductRequest(id, payload) {
  return api.put(`/products/${id}`, payload);
}

export function getUsersRequest() {
  return api.get('/users');
}

export function createUserRequest(payload) {
  return api.post('/users', payload);
}

export function getEligibleProductsRequest(id) {
  return api.get(`/users/${id}/eligible-products`);
}
