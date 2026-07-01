import { createRouter as createVueRouter, createWebHistory } from 'vue-router';
import { authState, syncAuthState } from '../services/auth';
import LoginPage from '../pages/LoginPage.vue';
import DashboardPage from '../pages/DashboardPage.vue';
import ProductsPage from '../pages/ProductsPage.vue';
import UsersPage from '../pages/UsersPage.vue';
import NotFoundPage from '../pages/NotFoundPage.vue';
import AdminLayout from '../layouts/AdminLayout.vue';

const routes = [
  {
    path: '/login',
    name: 'login',
    component: LoginPage,
    meta: { guest: true },
  },
  {
    path: '/',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'dashboard',
        component: DashboardPage,
      },
      {
        path: 'products',
        name: 'products',
        component: ProductsPage,
      },
      {
        path: 'users',
        name: 'users',
        component: UsersPage,
      },
    ],
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: NotFoundPage,
  },
];

export function createRouter() {
  const router = createVueRouter({
    history: createWebHistory(),
    routes,
  });

  syncAuthState();

  router.beforeEach((to) => {
    if (to.meta.requiresAuth && !authState.token) {
      return { name: 'login' };
    }

    if (to.meta.guest && authState.token) {
      return { name: 'dashboard' };
    }

    return true;
  });

  return router;
}
