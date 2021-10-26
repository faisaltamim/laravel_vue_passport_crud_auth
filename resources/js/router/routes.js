//Dependencies
import Vue from "vue";
import store from "../store/store";
import VueRouter from "vue-router";

//Dependencies uses
Vue.use(VueRouter);

//component file
import rootDashboard from "../Dashboard.vue";
import mainDashboard from "../components/dashboard/dashboard.vue";
import Category from "../components/manage_category/category.vue";
import Login from "../components/frontend/authentication/login.vue";
import Logout from "../components/frontend/authentication/logout.vue";
import Register from "../components/frontend/authentication/register.vue";
import ForgetPass from "../components/frontend/authentication/forget_pass.vue";

// const guest = (to, from, next) => {
//     if (!localStorage.getItem("auth_token")) {
//         return next();
//     } else {
//         return next({ name: "mainDashborad" });
//     }
// };
// const auth = (to, from, next) => {
//     if (localStorage.getItem("auth_token")) {
//         return next();
//     } else {
//         return next({ name: "login" });
//     }
// };

const routes = [
    {
        path: "/dashboard",
        component: rootDashboard,
        name: "mainDashborad",
        children: [
            {
                path: "",
                component: mainDashboard,
                name: "loadedDashboardComponent"
            },

            {
                path: "category",
                component: Category,
                name: "category"
            }
        ]
        // meta: {
        //     requiresAuth: true
        // }
        // beforeEnter: auth
    },

    {
        path: "/login",
        component: Login,
        name: "login"
    },
    {
        path: "/logout",
        component: Logout,
        name: "logout"
    },
    {
        path: "/register",
        component: Register,
        name: "register"
        // meta: {
        //     requiresAuth: true
        // }
    },
    {
        path: "/reset-password",
        component: ForgetPass,
        name: "reset_password"
    }

    // {
    //     //nicher ei route er maddhome unknown route ke redirect kore dibe 404 page er bodole
    //     path: "*",
    //     component: error404
    // },
];

export const router = new VueRouter({
    routes,
    mode: "history",
    scrollBehavior() {
        return {
            x: 0,
            y: 0
        };
    }
});

// router.beforeEach((to, from, next) => {
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//         // !store.getters.ifLoggedIn

//         let localServerToken = store.state.access_token;

//         if (!localServerToken) {
//             next({ name: "login" });
//         } else {
//             next();
//         }
//     } else {
//         next();
//     }
// });
