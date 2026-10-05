import AiAgentComponent from "../../components/admin/settings/AiAgent/AiAgentComponent.vue";

const SettingsComponent = () => import("../../components/admin/settings/SettingsComponent");
const CompanyComponent = () => import("../../components/admin/settings/Company/CompanyComponent");
const SiteComponent = () => import("../../components/admin/settings/Site/SiteComponent");
const ItemCategoryListComponent = () => import("../../components/admin/settings/ItemCategory/ItemCateogryListComponent");
const ItemCategoryComponent = () => import("../../components/admin/settings/ItemCategory/ItemCategoryComponent");
const ItemCategoryShowComponent = () => import("../../components/admin/settings/ItemCategory/ItemCategoryShowComponent");
const ItemAttributeComponent = () => import("../../components/admin/settings/ItemAttribute/ItemAttributeComponent");
const ItemAttributeListComponent = () => import("../../components/admin/settings/ItemAttribute/ItemAttributeListComponent");
const SliderComponent = () => import("../../components/admin/settings/Slider/SliderComponent");
const SliderListComponent = () => import("../../components/admin/settings/Slider/SliderListComponent");
const SliderShowComponent = () => import("../../components/admin/settings/Slider/SliderShowComponent");
const BranchComponent = () => import("../../components/admin/settings/Branch/BranchComponent");
const BranchListComponent = () => import("../../components/admin/settings/Branch/BranchListComponent");
const BranchShowComponent = () => import("../../components/admin/settings/Branch/BranchShowComponent");
const TaxComponent = () => import("../../components/admin/settings/Tax/TaxComponent");
const TaxListComponent = () => import("../../components/admin/settings/Tax/TaxListComponent");
const CurrencyComponent = () => import("../../components/admin/settings/Currency/CurrencyComponent");
const CurrencyListComponent = () => import("../../components/admin/settings/Currency/CurrencyListComponent");
const MailComponent = () => import("../../components/admin/settings/Mail/MailComponent");
const NotificationComponent = () => import("../../components/admin/settings/Notification/NotificationComponent");
const PageComponent = () => import("../../components/admin/settings/Page/PageComponent");
const PageListComponent = () => import("../../components/admin/settings/Page/PageListComponent");
const PageShowComponent = () => import("../../components/admin/settings/Page/PageShowComponent");
const OtpComponent = () => import("../../components/admin/settings/Otp/OtpComponent");
const SocialMediaComponent = () => import("../../components/admin/settings/SocialMedia/SocialMediaComponent");
const LicenseComponent = () => import("../../components/admin/settings/License/LicenseComponent");
const AnalyticComponent = () => import("../../components/admin/settings/analytics/AnalyticComponent");
const AnalyticListComponent = () => import("../../components/admin/settings/analytics/AnalyticListComponent");
const AnalyticShowComponent = () => import("../../components/admin/settings/analytics/AnalyticShowComponent");
const RoleComponent = () => import("../../components/admin/settings/Role/RoleComponent");
const RoleListComponent = () => import("../../components/admin/settings/Role/RoleListComponent");
const RoleShowComponent = () => import("../../components/admin/settings/Role/RoleShowComponent");
const CookiesComponent = () => import("../../components/admin/settings/Cookies/CookiesComponent");
const ThemeComponent = () => import("../../components/admin/settings/Theme/ThemeComponent");
const TimeSlotListComponent = () => import("../../components/admin/settings/TimeSlot/TimeSlotListComponent");
const LanguageComponent = () => import("../../components/admin/settings/Language/LanguageComponent");
const LanguageListComponent = () => import("../../components/admin/settings/Language/LanguageListComponent");
const LanguageShowComponent = () => import("../../components/admin/settings/Language/LanguageShowComponent");
const OrderSetupComponent = () => import("../../components/admin/settings/OrderSetup/OrderSetupComponent");
const PaymentGatewayComponent = () => import("../../components/admin/settings/PaymentGateway/PaymentGatewayComponent");
const SmsGatewayComponent = () => import("../../components/admin/settings/SmsGateway/SmsGatewayComponent");
const NotificationAlertComponent = () => import("../../components/admin/settings/NotificationAlert/NotificationAlertComponent");
const KioskMachineComponent = () => import("../../components/admin/settings/KioskMachine/KioskMachineComponent.vue");
const KioskMachineListComponent = () => import("../../components/admin/settings/KioskMachine/KioskMachineListComponent.vue");
const SocialLoginComponent = () => import("../../components/admin/settings/SocialLogin/SocialLoginComponent");

export default [
    {
        path: "/admin/settings",
        component: SettingsComponent,
        name: "admin.settings",
        redirect: { name: "admin.settings.company" },
        meta: {
            isFrontend: false,
            auth: true,
            permissionUrl: "settings",
            breadcrumb: "settings",
        },
        children: [
            {
                path: "company",
                component: CompanyComponent,
                name: "admin.settings.company",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "company",
                },
            },
            {
                path: "site",
                component: SiteComponent,
                name: "admin.settings.site",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "site",
                },
            },
            {
                path: "branches",
                component: BranchComponent,
                name: "admin.settings.branch",
                redirect: { name: "admin.settings.branch.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "branches",
                },
                children: [
                    {
                        path: "list",
                        component: BranchListComponent,
                        name: "admin.settings.branch.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                    {
                        path: "show/:id",
                        component: BranchShowComponent,
                        name: "admin.settings.branch.show",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "view",
                        },
                    },
                ],
            },
            {
                path: "mail",
                component: MailComponent,
                name: "admin.settings.mail",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "mail",
                },
            },
            {
                path: "order-setup",
                component: OrderSetupComponent,
                name: "admin.settings.orderSetup",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "order_setup",
                },
            },
            {
                path: "otp",
                component: OtpComponent,
                name: "admin.settings.otp",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "otp",
                },
            },
            {
                path: "notification",
                component: NotificationComponent,
                name: "admin.settings.notification",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "notification",
                },
            },
            {
                path: "social-media",
                component: SocialMediaComponent,
                name: "admin.settings.socialMedia",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "social_media",
                },
            },
            {
                path: "social-login",
                component: SocialLoginComponent,
                name: "admin.settings.socialLogin",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "social_login",
                },
            },
            {
                path: "cookies",
                component: CookiesComponent,
                name: "admin.settings.cookies",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "cookies",
                },
            },
            {
                path: "analytics",
                component: AnalyticComponent,
                name: "admin.settings.analytic",
                redirect: { name: "admin.settings.analytic.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "analytics",
                },
                children: [
                    {

                        path: "list",
                        component: AnalyticListComponent,
                        name: "admin.settings.analytic.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                    {
                        path: "show/:id",
                        component: AnalyticShowComponent,
                        name: "admin.settings.analytic.show",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "view",
                        },
                    },
                ]
            },
            {
                path: "theme",
                component: ThemeComponent,
                name: "admin.settings.theme",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "theme",
                },
            },
            {
                path: "time-slots",
                component: TimeSlotListComponent,
                name: "admin.settings.timeSlot",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "time_slots",
                }
            },
            {
                path: "sliders",
                component: SliderComponent,
                name: "admin.settings.slider",
                redirect: { name: "admin.settings.slider.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "sliders",
                },
                children: [
                    {
                        path: "list",
                        component: SliderListComponent,
                        name: "admin.settings.slider.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                    {
                        path: "show/:id",
                        component: SliderShowComponent,
                        name: "admin.settings.slider.show",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "view",
                        },
                    },
                ],
            },
            {
                path: "currencies",
                component: CurrencyComponent,
                name: "admin.settings.currency",
                redirect: { name: "admin.settings.currency.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "currencies",
                },
                children: [
                    {
                        path: "list",
                        component: CurrencyListComponent,
                        name: "admin.settings.currency.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                ],
            },
            {
                path: "item-categories",
                component: ItemCategoryComponent,
                name: "admin.settings.itemCategory",
                redirect: { name: "admin.settings.itemCategory.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "item_categories",
                },
                children: [
                    {
                        path: "list",
                        component: ItemCategoryListComponent,
                        name: "admin.settings.itemCategory.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                    {
                        path: "show/:id",
                        component: ItemCategoryShowComponent,
                        name: "admin.settings.itemCategory.show",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "view",
                        },
                    },
                ],
            },
            {
                path: "item-attributes",
                component: ItemAttributeComponent,
                name: "admin.settings.itemAttribute",
                redirect: { name: "admin.settings.itemAttribute.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "item_attributes",
                },
                children: [
                    {
                        path: "list",
                        component: ItemAttributeListComponent,
                        name: "admin.settings.itemAttribute.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                ],
            },
            {
                path: "taxes",
                component: TaxComponent,
                name: "admin.settings.tax",
                redirect: { name: "admin.settings.tax.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "taxes",
                },
                children: [
                    {
                        path: "list",
                        component: TaxListComponent,
                        name: "admin.settings.tax.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                ],
            },
            {
                path: "pages",
                component: PageComponent,
                name: "admin.settings.page",
                redirect: { name: "admin.settings.page.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "pages",
                },
                children: [
                    {
                        path: "list",
                        component: PageListComponent,
                        name: "admin.settings.page.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                    {
                        path: "show/:id",
                        component: PageShowComponent,
                        name: "admin.settings.page.show",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "view",
                        },
                    },
                ],
            },
            {
                path: "role",
                component: RoleComponent,
                name: "admin.settings.role",
                redirect: { name: "admin.settings.role.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "role_permissions",
                },
                children: [
                    {
                        path: "list",
                        component: RoleListComponent,
                        name: "admin.settings.role.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                    {
                        path: "show/:id",
                        component: RoleShowComponent,
                        name: "admin.settings.role.show",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "view",
                        },
                    },
                ],
            },
            {
                path: "languages",
                component: LanguageComponent,
                name: "admin.settings.language",
                redirect: { name: "admin.settings.language.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "languages",
                },
                children: [
                    {
                        path: "list",
                        component: LanguageListComponent,
                        name: "admin.settings.language.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                    {
                        path: "show/:id",
                        component: LanguageShowComponent,
                        name: "admin.settings.language.show",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "view",
                        },
                    },
                ],
            },
            {
                path: "ai-agent",
                component: AiAgentComponent,
                name: "admin.settings.aiAgent",
                meta: {
                    template: "admin",
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "ai_agent"
                },
            },
            {
                path: "sms-gateway",
                component: SmsGatewayComponent,
                name: "admin.settings.smsGateway",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "sms_gateway",
                },
            },
            {
                path: "payment-gateway",
                component: PaymentGatewayComponent,
                name: "admin.settings.paymentGateway",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "payment_gateway",
                },
            },
            {
                path: "license",
                component: LicenseComponent,
                name: "admin.settings.license",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "license",
                }
            },
            {
                path: "notification-alert",
                component: NotificationAlertComponent,
                name: "admin.settings.notificationAlert",
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "notification_alert",
                }
            },
            {
                path: "kiosk-machines",
                component: KioskMachineComponent,
                name: "admin.settings.kioskMachines",
                redirect: { name: "admin.settings.kioskMachines.list" },
                meta: {
                    isFrontend: false,
                    auth: true,
                    permissionUrl: "settings",
                    breadcrumb: "kiosk_machines",
                },
                children: [
                    {
                        path: "list",
                        component: KioskMachineListComponent,
                        name: "admin.settings.kioskMachines.list",
                        meta: {
                            isFrontend: false,
                            auth: true,
                            permissionUrl: "settings",
                            breadcrumb: "",
                        },
                    },
                ],
            },
        ],
    },
];
