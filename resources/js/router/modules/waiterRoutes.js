const WaiterComponent = () => import("../../components/admin/waiters/WaiterComponent.vue");
const WaiterListComponent = () => import("../../components/admin/waiters/WaiterListComponent.vue");
const WaiterShowComponent = () => import("../../components/admin/waiters/WaiterShowComponent.vue");
const WaiterOrderDetailsComponent = () => import("../../components/admin/waiters/WaiterOrderDetailsComponent.vue");


export default [
    {
        path: "/admin/waiters",
        component: WaiterComponent,
        name: "admin.waiters",
        redirect: { name: "admin.waiters.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "waiters",
            breadcrumb: "waiters",
        },
        children: [
            {
                path: "",
                component: WaiterListComponent,
                name: "admin.waiters.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "waiters",
                    breadcrumb: "",
                }
            },
            {
                path: "show/:id",
                component: WaiterShowComponent,
                name: "admin.waiters.show",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "waiters",
                    breadcrumb: "view",
                }
            },
            {
                path: "show/:id/:orderId",
                component: WaiterOrderDetailsComponent,
                name: "admin.waiters.order.details",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "waiters",
                    breadcrumb: "order_details",
                }
            },
        ],
    },
];
