import Dashboard from "../components/dashboard/dashboard.vue";
import Category from "../components/manage_category/category.vue";

export const routes = [
    {
        path: "/",
        component: Dashboard,
        name: "dashboard"
    },
    {
        path: "/category",
        component: Category,
        name: "category"
    }
    // {
    //     //nicher ei route er maddhome unknown route ke redirect kore dibe 404 page er bodole
    //     path: "*",
    //     component: error404
    // },
];
