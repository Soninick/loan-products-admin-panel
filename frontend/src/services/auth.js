import { reactive } from 'vue';
import { clearSession, getToken, getUser, setSession } from '../utils/storage';

export const authState = reactive({
  token: getToken(),
  user: getUser(),
});

export function syncAuthState() {
  authState.token = getToken();
  authState.user = getUser();
}

export function storeAuthSession(token, user) {
  setSession(token, user);
  syncAuthState();
  window.dispatchEvent(new Event('auth-storage-changed'));
}

export function clearAuthSession() {
  clearSession();
  syncAuthState();
  window.dispatchEvent(new Event('auth-storage-changed'));
}

window.addEventListener('auth-storage-changed', syncAuthState);
