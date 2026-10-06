<template>
    <LoadingComponent :props="loading" />
    <section class="pt-8 pb-16">
        <div class="container max-w-[360px] py-6 p-4 sm:px-6 shadow-xs rounded-2xl bg-white">
            <h2 class="capitalize mb-6 text-center text-[22px] font-semibold leading-[34px] text-heading">{{
                $t('label.lets_get_started')
                }}
            </h2>
            <form @submit.prevent="save">
                <div class="mb-6">
                    <label for="phone" class="text-sm capitalize mb-1 text-heading">
                        {{ $t('label.mobile_number') }}
                    </label>
                    <div :class="errors.phone ? 'invalid border-danger' : 'border-[#D9DBE9]'"
                        dir="ltr"
                        class="w-full h-12 rounded-lg border flex items-center bg-white overflow-hidden transition-all focus-within:border-primary">
                        <div class="h-full flex items-center gap-1.5 px-3 bg-gray-50 flex-shrink-0 border-r border-[#D9DBE9] select-none cursor-default">
                            <span class="text-base leading-none">{{ flag }}</span>
                            <span dir="ltr" class="whitespace-nowrap text-sm font-semibold text-heading" style="unicode-bidi: isolate;">{{ props.form.code }}</span>
                            <input type="hidden" v-model="props.form.code">
                        </div>
                        <input id="phone" v-model="props.form.phone" v-on:keyup.enter="save"
                            v-on:keypress="phoneNumber($event)" type="text"
                            dir="ltr"
                            placeholder="1xxxxxxxxx"
                            class="px-3 text-sm w-full h-full text-heading border-none outline-none focus:outline-none focus:ring-0 bg-transparent text-left">
                    </div>
                    <small class="db-field-alert" v-if="errors.phone">
                        {{ errors.phone[0] }}
                    </small>
                </div>
                <button type="submit"
                    class="w-full h-12 text-center capitalize font-medium rounded-3xl mb-6 text-white bg-primary">
                    {{ $t('label.next') }}
                </button>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-base text-[#6E7191]">{{ $t('label.already_have_an_account') }}</span>
                    <router-link :to="{ name: 'auth.login' }" class="text-base font-medium text-primary">
                        {{ $t('label.login') }}
                    </router-link>
                </div>
            </form>
        </div>
    </section>
</template>

<script>

import appService from "../../../services/appService";
import askEnum from "../../../enums/modules/askEnum"
import alertService from "../../../services/alertService";
import LoadingComponent from "../components/LoadingComponent";

export default {
    name: "SignupPhoneComponent",
    components: { LoadingComponent },
    data() {
        return {
            loading: {
                isActive: false,
            },
            props: {
                form: {
                    phone: "",
                    code: "",
                },
            },
            flag: "",
            country_code: "",
            errors: {},
            phone_verification: "",
        };
    },
    mounted() {
        this.loading.isActive = true;
        this.$store.dispatch('frontendSetting/lists').then(res => {
            this.defaultCountryCode = res.data.data.company_country_code;
            this.$store.dispatch('frontendCountryCode/show', this.defaultCountryCode).then(res => {
                this.props.form.code = res.data.data.calling_code;
                this.country_code = res.data.data.calling_code;
                this.flag = res.data.data.flag_emoji;
                this.loading.isActive = false;
            }).catch((err) => {
                this.loading.isActive = false;
            });
            this.loading.isActive = false;
        }).catch((err) => {
            this.loading.isActive = false;
        });
    },
    computed: {
        countryCode: function () {
            return this.$store.getters['frontendCountryCode/show'];
        },
        setting: function () {
            return this.$store.getters['frontendSetting/lists'];
        }
    },
    methods: {
        phoneNumber(e) {
            return appService.phoneNumber(e);
        },
        save: function () {
            try {
                this.loading.isActive = true;
                this.$store.dispatch("frontendSignup/otp", this.props.form).then((res) => {
                    this.loading.isActive = false;

                    if (this.setting.site_phone_verification === askEnum.NO) {
                        this.$router.push({ name: "auth.signupRegister" });
                    } else {
                        alertService.success(res.data.message);
                        this.$router.push({ name: "auth.signupVerify" });
                    }

                    this.props.form = {
                        phone: "",
                        code: this.country_code,
                    };
                    this.errors = {};
                }).catch((err) => {
                    this.loading.isActive = false;
                    this.errors = err.response.data.errors;
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err);
            }
        },
    },
}
</script>