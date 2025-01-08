import { createRouter, createWebHistory } from "vue-router";

const routes = [
    { 
        path: '/login', 
        name: 'Login', 
        component: () => import("@/./views/Login.vue"),
        meta: { requiresAuth: false },
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("@/./views/Register.vue"),
        meta: { requiresAuth: false },
    },
    {
        path: "/",
        name: "Home",
        component: () => import("@/./views/Dashboard.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: () => import("@/./views/Dashboard.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/role",
        name: "Role",
        component: () => import("@/./views/Role.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/profile",
        name: "Profile",
        component: () => import("@/./views/Profile.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: '/:catchAll(.*)',
        redirect: '/login',
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {        
        const isAuthenticated = localStorage.getItem('token');

        if (!isAuthenticated) {
            next('/login'); // Redirect to login
        } else {
            next(); // Allow navigation
        }
    } else {
        if (( to.path !== '/login' || to.path !== '/register' || to.path !== '/') && !localStorage.getItem('token')) 
            {
            next(); // Allow navigation for routes without `requiresAuth`
        }
        next('/dashboard');
    }
});

export default router;