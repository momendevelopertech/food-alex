const OfferComponent = () => import("../../components/admin/offers/OfferComponent");
const OfferListComponent = () => import("../../components/admin/offers/OfferListComponent");
const OfferShowComponent = () => import("../../components/admin/offers/OfferShowComponent");

export default [
    {
        path: '/admin/offers',
        component: OfferComponent,
        name: 'admin.offers',
        redirect: { name: 'admin.offers.list' },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: 'offers',
            breadcrumb: 'offers'
        },
        children: [
            {
                path: '',
                component: OfferListComponent,
                name: 'admin.offers.list',
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: 'offers',
                    breadcrumb: ''
                },
            },
            {
                path: "show/:id",
                component: OfferShowComponent,
                name: "admin.offer.show",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "offers",
                    breadcrumb: "view",
                },
            },
        ]
    }
]
