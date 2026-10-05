const TableMenuComponent = () => import("../../components/table/tableMenu/TableMenuComponent");
const SearchItemComponent = () => import("../../components/table/search/SearchItemComponent.vue");
const PageComponent = () => import("../../components/table/page/PageComponent.vue");
const CheckoutComponent = () => import("../../components/table/checkout/CheckoutComponent.vue");
const OrderDetailsComponent = () => import("../../components/table/order/OrderDetailsComponent.vue");

export default [
    {
        path: "/menu/:slug",
        component: TableMenuComponent,
        name: "table.menu.table",
        meta: {
            isTable: true,
            auth: false,
        },
    },
    {
        path: "/search/:slug",
        component: SearchItemComponent,
        name: "table.search",
        meta: {
            isTable: true,
            auth: false,
        },
    },
    {
        path: "/page/:slug/:pageSlug",
        component: PageComponent,
        name: "table.page",
        meta: {
            isTable: true,
            auth: false,
        },
    },
    {
        path: "/checkout/:slug",
        component: CheckoutComponent,
        name: "table.checkout",
        meta: {
            isTable: true,
            auth: false,
        },
    },
    {
        path: "/table-order/:slug/:id",
        component: OrderDetailsComponent,
        name: "table.tableOrder.details",
        meta: {
            isTable: true,
            auth: false,
        },
    },
];
