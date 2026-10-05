const DeliveryBoyComponent = () => import("../../components/admin/deliveryBoys/DeliveryBoyComponent");
const DeliveryBoyListComponent = () => import("../../components/admin/deliveryBoys/DeliveryBoyListComponent");
const DeliveryBoyShowComponent = () => import("../../components/admin/deliveryBoys/DeliveryBoyShowComponent");
const DeliveryBoyOrderDetailsComponent = () => import("../../components/admin/deliveryBoys/DeliveryBoyOrderDetailsComponent");
const DeliveredOrderShowComponent = () => import("../../components/admin/deliveryBoys/deliveredOrder/DeliveredOrderShowComponent");

export default [
    {
        path: "/admin/delivery-boys",
        component: DeliveryBoyComponent,
        name: "admin.delivery-boys",
        redirect: { name: "admin.delivery-boys.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "delivery-boys",
            breadcrumb: "delivery_boys",
        },
        children: [
            {
                path: "",
                component: DeliveryBoyListComponent,
                name: "admin.delivery-boys.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "delivery-boys",
                    breadcrumb: "",
                },
            },
            {
                path: "show/:id",
                component: DeliveryBoyShowComponent,
                name: "admin.delivery-boys.show",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "delivery-boys",
                    breadcrumb: "view",
                },
            },
            {
                path: "show/:id/:orderId",
                component: DeliveryBoyOrderDetailsComponent,
                name: "admin.delivery-boys.order.details",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "delivery-boys",
                    breadcrumb: "order_details",
                },
            },
            {
                path: "delivered-order/show/:id/:orderId",
                component: DeliveredOrderShowComponent,
                name: "admin.delivery-boys.delivered-order.details",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "delivery-boys",
                    breadcrumb: "delivered_order_details",
                },
            },
        ],
    },
];
