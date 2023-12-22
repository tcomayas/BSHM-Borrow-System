import { createRouter, createWebHistory } from "vue-router";
import {ref} from 'vue'

import StudentLayout from '../components/Layouts/StudentLayout.vue'
import GuestLayout from '../components/Layouts/GuestLayout.vue'
import AdminLayout from '../components/Layouts/AdminLayout.vue'

const user = ref(null)
function isLoggedIn() {
    user.value = JSON.parse(localStorage.getItem('auth'))
    if(!user.value) {
        return false
    } return true
}

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes: [
      {
        path: '/testing',
        meta: {layout: GuestLayout},
        component: () => import('../components/testing.vue'),
      },
        {
            path: '/',
            name: 'Announcements',
            meta: {layout: StudentLayout, requiresAuth: true },
            component: () => import('../components/Student/Announcements.vue'),
        },
        {
            path: '/sign-in',
            name: 'Signin',
            meta: {layout: GuestLayout},
            component: () => import('../components/Signin.vue'),
        },
        {
            path: '/sign-up',
            name: 'Signup',
            meta: {layout: GuestLayout},
            component: () => import('../components/Signup.vue'),
        },
        {
            path: '/account',
            name: 'Account',
            meta: { layout: StudentLayout, requiresAuth: true },
            component: () => import('../components/Student/Account.vue')
        },
        {
            path: '/resources',
            name: 'Resources',
            meta: { layout: StudentLayout, requiresAuth: true },
            component: () => import('../components/Student/Resources.vue')
        },
        {
            path: '/admin/dashboard',
            name: 'AdminDashboard',
            meta: {layout: AdminLayout, requiresAuth: true},
            component: () => import('../components/Admin/AdminDashboard.vue'),
        },
        {
          path: '/admin/inventory',
          name: 'ItemInventory',
          meta: { layout: AdminLayout, requiresAuth: true },
          component: () => import('../components/Admin/ItemInventory.vue')
        },
        {
            path: '/admin/manage-users',
            name: 'ManageUsers',
            meta: {layout: AdminLayout, requiresAuth: true},
            component: () => import('../components/Admin/ManageUsers.vue')
        },
    ]
})

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if(isLoggedIn()) {
            next()
        }
        else {
            next({name: 'Signin'})
        }
    }
    else {
        next()
    }
})

export default router
