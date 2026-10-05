const ChefComponent = () => import("../../components/admin/chefs/ChefComponent.vue");
const ChefListComponent = () => import("../../components/admin/chefs/ChefListComponent.vue");
const ChefShowComponent = () => import("../../components/admin/chefs/ChefShowComponent.vue");
const ChefOrderDetailsComponent = () => import("../../components/admin/chefs/ChefOrderDetailsComponent.vue");


export default [
    {
        path: "/admin/chefs",
        component: ChefComponent,
        name: "admin.chefs",
        redirect: { name: "admin.chefs.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "chefs",
            breadcrumb: "chefs",
        },
        children: [
            {
                path: "",
                component: ChefListComponent,
                name: "admin.chefs.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "chefs",
                    breadcrumb: "",
                }
            },
            {
                path: "show/:id",
                component: ChefShowComponent,
                name: "admin.chefs.show",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "chefs",
                    breadcrumb: "view",
                }
            },
            {
                path: "show/:id/:orderId",
                component: ChefOrderDetailsComponent,
                name: "admin.chefs.order.details",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "chefs",
                    breadcrumb: "order_details",
                }
            },
        ],
    },
];
