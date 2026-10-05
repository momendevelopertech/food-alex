const HomeComponent = () => import("../../components/frontend/home/HomeComponent");
const MenuComponent = () => import("../../components/frontend/menu/MenuComponent");
const OffersComponent = () => import("../../components/frontend/offers/OffersComponent");
const OffersItemComponent = () => import("../../components/frontend/offers/OffersItemComponent");
const PageComponent = () => import("../../components/frontend/page/PageComponent");
const EditProfileComponent = () => import("../../components/frontend/account/editProfile/EditProfileComponent");
const MyOrderComponent = () => import("../../components/frontend/account/myOrder/MyOrderComponent");
const OrderDetailsComponent = () => import("../../components/frontend/account/myOrder/OrderDetailsComponent");
const ChatComponent = () => import("../../components/frontend/account/chat/ChatComponent");
const AddressComponent = () => import("../../components/frontend/account/address/AddressComponent");
const ChangePasswordComponent = () => import("../../components/frontend/account/changePassword/ChangePasswordComponent");
const CheckoutComponent = () => import("../../components/frontend/checkout/CheckoutComponent");
const SearchItemComponent = () => import("../../components/frontend/search/SearchItemComponent");

export default [
    {
        path: "/home",
        component: HomeComponent,
        name: "frontend.home",
        meta: {
            isFrontend: true,
            auth: false,
        },
    },
    {
        path: "/menu",
        component: MenuComponent,
        name: "frontend.menu",
        meta: {
            isFrontend: true,
            auth: false,
        },
    },
    {
        path: "/offers",
        component: OffersComponent,
        name: "frontend.offers",
        meta: {
            isFrontend: true,
            auth: false,
        },
    },
    {
        path: "/offers/:slug",
        component: OffersItemComponent,
        name: "frontend.offers.item",
        meta: {
            isFrontend: true,
            auth: false,
        },
    },
    {
        path: "/page/:slug",
        component: PageComponent,
        name: "frontend.page",
        meta: {
            isFrontend: true,
            auth: false,
        },
    },
    {
        path: "/edit-profile",
        component: EditProfileComponent,
        name: "frontend.editProfile",
        meta: {
            isFrontend: true,
            auth: true,
        },
    },
    {
        path: "/my-orders",
        component: MyOrderComponent,
        name: "frontend.myOrder",
        meta: {
            isFrontend: true,
            auth: true,
        },
    },
    {
        path: "/my-orders/:id",
        component: OrderDetailsComponent,
        name: "frontend.myOrder.details",
        meta: {
            isFrontend: true,
            auth: true,
        },
    },
    {
        path: "/chat",
        component: ChatComponent,
        name: "frontend.chat",
        meta: {
            isFrontend: true,
            auth: true,
        },
    },
    {
        path: "/address",
        component: AddressComponent,
        name: "frontend.address",
        meta: {
            isFrontend: true,
            auth: true,
        },
    },
    {
        path: "/change-password",
        component: ChangePasswordComponent,
        name: "frontend.changePassword",
        meta: {
            isFrontend: true,
            auth: true,
        },
    },
    {
        path: "/checkout",
        component: CheckoutComponent,
        name: "frontend.checkout",
        meta: {
            isFrontend: true,
            auth: true,
        },
    },
    {
        path: "/search",
        component: SearchItemComponent,
        name: "frontend.search",
        meta: {
            isFrontend: true,
            auth: false,
        },
    },
];
