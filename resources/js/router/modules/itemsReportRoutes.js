const ItemsReportComponent = () => import("../../components/admin/itemsReport/ItemsReportComponent");
const ItemsReportListComponent = () => import("../../components/admin/itemsReport/ItemsReportListComponent");
export default [
    {
        path: "/admin/items-report",
        component: ItemsReportComponent,
        name: "admin.items-report",
        redirect: { name: "admin.items-report.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "items-report",
            breadcrumb: "items_report",
        },
        children: [
            {
                path: "",
                component: ItemsReportListComponent,
                name: "admin.items-report.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "items-report",
                    breadcrumb: "",
                },
            },
        ],
    },
];
