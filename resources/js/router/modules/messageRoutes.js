const MessageComponent = () => import("../../components/admin/messages/MessageComponent");
const MessageListComponent = () => import("../../components/admin/messages/MessageListComponent");

export default [
    {
        path: "/admin/messages",
        component: MessageComponent,
        name: "admin.messages",
        redirect: { name: "admin.messages.list" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "messages",
            breadcrumb: "messages",
        },
        children: [
            {
                path: "",
                component: MessageListComponent,
                name: "admin.messages.list",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "messages",
                    breadcrumb: "",
                },
            },
        ],
    },
];
