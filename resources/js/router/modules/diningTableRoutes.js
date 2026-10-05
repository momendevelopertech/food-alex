const DiningTableListComponent = () => import("../../components/admin/diningTable/DiningTableListComponent");
const DiningTableComponent = () => import("../../components/admin/diningTable/DiningTableComponent");
const DiningTableShowComponent = () => import("../../components/admin/diningTable/DiningTableShowComponent");

export default [
    {
        path: "/admin/dining-tables",
        component: DiningTableComponent,
        name: "admin.diningTable",
        redirect: { name: "admin.diningTable.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "dining-tables",
            breadcrumb: "dining_tables",
        },
        children: [
            {
                path: "list",
                component: DiningTableListComponent,
                name: "admin.diningTable.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "dining-tables",
                    breadcrumb: "",
                },
            },
            {
                path: "show/:id",
                component: DiningTableShowComponent,
                name: "admin.diningTable.show",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "dining-tables",
                    breadcrumb: "view",
                },
            },
        ],
    },
]
