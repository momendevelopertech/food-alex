<template>
  <div :dir="direction">
    <div v-if="theme === 'frontend'">
      <FrontendNavbarComponent />
      <FrontendCartComponent />
      <router-view></router-view>
      <FrontendMobileNavBarComponent />
      <FrontendMobileAccountComponent />
      <FrontendCookiesComponent />
      <FrontendFooterComponent />
      <!-- Floating WhatsApp Button (Only on frontend website) -->
      <a v-if="whatsappNumber" :href="'https://wa.me/' + whatsappNumber" target="_blank" rel="noopener noreferrer"
         aria-label="WhatsApp"
         class="fixed z-50 bg-[#25D366] text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-transform hover:scale-110 ltr:right-5 rtl:left-5 bottom-20 lg:bottom-6">
          <i class="fa-brands fa-whatsapp text-3xl"></i>
      </a>
    </div>

    <div v-if="theme === 'backend'">
      <main class="db-main" v-if="logged">
        <BackendNavbarComponent />
        <BackendMenuComponent />
        <router-view></router-view>
        <BackendAiSidebarComponent />
      </main>

      <div v-if="!logged">
        <router-view></router-view>
      </div>
    </div>

    <div v-if="theme === 'table'">
      <TableNavbarComponent />
      <TableCartComponent />
      <router-view></router-view>
      <TableFooterComponent />
    </div>
  </div>
</template>

<script>
import BackendNavbarComponent from "./layouts/backend/BackendNavbarComponent";
import BackendMenuComponent from "./layouts/backend/BackendMenuComponent";
import FrontendNavbarComponent from "./layouts/frontend/FrontendNavBarComponent";
import FrontendFooterComponent from "./layouts/frontend/FrontendFooterComponent";
import FrontendMobileNavBarComponent from "./layouts/frontend/FrontendMobileNavBarComponent";
import FrontendMobileAccountComponent from "./layouts/frontend/FrontendMobileAccountComponent";
import FrontendCartComponent from "./layouts/frontend/FrontendCartComponent";
import FrontendCookiesComponent from "./layouts/frontend/FrontendCookiesComponent";
import TableNavbarComponent from "./layouts/table/TableNavBarComponent.vue";
import TableFooterComponent from "./layouts/table/TableFooterComponent.vue";
import TableCartComponent from "./layouts/table/TableCartComponent.vue";
import displayModeEnum from "../enums/modules/displayModeEnum";
import env from "../config/env";
import BackendAiSidebarComponent from "./layouts/backend/BackendAiSidebarComponent.vue";

export default {
  name: "DefaultComponent",
  components: {
    TableCartComponent,
    TableFooterComponent,
    TableNavbarComponent,
    FrontendCartComponent,
    FrontendMobileAccountComponent,
    FrontendMobileNavBarComponent,
    FrontendCookiesComponent,
    FrontendFooterComponent,
    FrontendNavbarComponent,
    BackendNavbarComponent,
    BackendMenuComponent,
    BackendAiSidebarComponent
  },
  data() {
    return {
      theme: "frontend",
    };
  },
  created() {
    if (this.$route?.meta?.isFrontend === true) {
      this.theme = "frontend";
    } else if (this.$route?.meta?.isTable === true) {
      this.theme = "table";
    } else if (this.$route?.path?.includes('/admin')) {
      this.theme = "backend";
    }
  },
  computed: {
    direction: function () {
      const show = this.$store.getters['frontendLanguage/show'];
      if (show && typeof show.display_mode !== 'undefined') {
        return show.display_mode === displayModeEnum.RTL ? 'rtl' : 'ltr';
      }
      if (typeof document !== 'undefined') {
        const cookieMatch = document.cookie.match(/(?:^|;\s*)locale=([^;]+)/);
        const cookieLocale = cookieMatch ? cookieMatch[1] : null;
        if (cookieLocale === 'ar' || document.documentElement.dir === 'rtl') {
          return 'rtl';
        }
      }
      return (this.$i18n && this.$i18n.locale === 'ar') ? 'rtl' : 'ltr';
    },
    whatsappNumber: function () {
      if (typeof window !== 'undefined' && typeof WHATSAPP_NUMBER !== 'undefined' && WHATSAPP_NUMBER) {
        let num = String(WHATSAPP_NUMBER).replace(/[^0-9]/g, '');
        if (num.startsWith('0')) {
          num = '20' + num.substring(1);
        }
        return num;
      }
      return '201012345678';
    },
    logged: function () {
      return this.$store.getters.authStatus;
    },
  },
  beforeMount() {
    this.$store
      .dispatch("frontendSetting/lists")
      .then((res) => {
        const defaultLang = res.data.data.site_default_language;
        this.$store.dispatch("globalState/init", {
          branch_id: res.data.data.site_default_branch,
          language_id: defaultLang,
        });
        const activeLangId = this.$store.getters['globalState/lists']?.language_id || defaultLang;
        if (activeLangId) {
          this.$store.dispatch('frontendLanguage/show', activeLangId).then(lRes => {
            if (lRes?.data?.data?.code) {
              this.$i18n.locale = lRes.data.data.code;
            }
          }).catch();
        }
      })
      .catch();


    if (env.DEMO === "true" || env.DEMO === 'TRUE' || env.DEMO === true || env.DEMO === "1" || env.DEMO === 1) {
      this.$store.dispatch("authcheck").then(res => {
        if (res.data.status === false && (this.theme == "frontend" || this.theme == "backend")) {
          this.$router.push({ name: "frontend.home" });
        };
      }).catch();
    }

  },
  watch: {
    direction: {
      immediate: true,
      handler(val) {
        if (typeof document !== 'undefined') {
          document.documentElement.dir = val;
        }
      }
    },
    $route(e) {
      if (e.meta.isFrontend === true) {
        this.theme = "frontend";
      } else if (e.meta.isTable === true) {
        this.theme = "table";
      } else {
        this.theme = "backend";
      }
    },
  },
};
</script>
