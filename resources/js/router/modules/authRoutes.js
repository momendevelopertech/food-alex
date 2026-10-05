const LoginComponent = () => import("../../components/frontend/auth/LoginComponent");
const ForgetPasswordComponent = () => import("../../components/frontend/auth/ForgetPasswordComponent");
const GuestLoginComponent = () => import("../../components/frontend/auth/GuestLoginComponent");
const VerifyEmailComponent = () => import("../../components/frontend/auth/VerifyEmailComponent");
const ResetPasswordComponent = () => import("../../components/frontend/auth/ResetPasswordComponent");
const GuestVerifyComponent = () => import("../../components/frontend/auth/GuestVerifyComponent");
const SignupPhoneComponent = () => import("../../components/frontend/auth/SignupPhoneComponent");
const SignupVerifyComponent = () => import("../../components/frontend/auth/SignupVerifyComponent");
const SignupRegisterComponent = () => import("../../components/frontend/auth/SignupRegisterComponent");
const SocialLoginComponent = () => import("../../components/frontend/socialLogin/SocialLoginComponent.vue");

export default [
    {
        path: '/login',
        component: LoginComponent,
        name: 'auth.login',
        meta: {
            isFrontend: true,
            auth: false
        }
    },
    {
        path: '/forget-password',
        component: ForgetPasswordComponent,
        name: 'auth.forgetPassword',
        meta: {
            isFrontend: true,
            auth: false
        }
    },
    {
        path: '/forget-password/verify',
        name: 'auth.verifyEmail',
        component: VerifyEmailComponent,
        meta: {
            isFrontend: true,
            auth: false
        }
    },
    {
        path: '/forget-password/reset-password',
        name: 'auth.resetPassword',
        component: ResetPasswordComponent,
        meta: {
            isFrontend: true,
            auth: false
        }
    },
    {
        path: "/login/google/callback",
        component: SocialLoginComponent,
        name: "frontend.socialLogin",
        meta: {
            isFrontend: true,
            auth: false,
        },
    },
    {
        path: '/signup',
        component: SignupPhoneComponent,
        name: 'auth.signupPhone',
        meta: {
            isFrontend: true,
            auth: false
        }
    },
    {
        path: '/signup/verify',
        component: SignupVerifyComponent,
        name: 'auth.signupVerify',
        meta: {
            isFrontend: true,
            auth: false
        }
    },
    {
        path: '/signup/register',
        component: SignupRegisterComponent,
        name: 'auth.signupRegister',
        meta: {
            isFrontend: true,
            auth: false
        }
    },
    {
        path: '/guest-login',
        component: GuestLoginComponent,
        name: 'auth.guestLogin',
        meta: {
            isFrontend: true,
            auth: false
        }
    },
    {
        path: '/guest-login/verify',
        component: GuestVerifyComponent,
        name: 'auth.guestLoginVerify',
        meta: {
            isFrontend: true,
            auth: false
        }
    }
];
