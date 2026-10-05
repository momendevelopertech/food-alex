<template>
    <button @click="openSettingMenu($event)" type="button"
        class="settings-btn w-full md:hidden flex items-center justify-center gap-2 p-2 rounded bg-primary text-white">
        <span class="capitalize">{{ $t('menu.settings_menu') }}</span>
        <i class="icon fa-solid fa-chevron-down text-sm"></i>
    </button>
    <div class="h-0 overflow-hidden md:h-auto md:overflow-auto transition-all duration-300">
        <nav class="db-card p-3">
            <router-link v-for="menu in settingMenus" :key="menu.id" :to="'/admin/settings/' + menu.url" class="db-tab-btn">
                <i :class="menu.icon" class="text-sm"></i>
                {{ $t('menu.' + menu.language) }}
            </router-link>
        </nav>
    </div>
</template>

<script>
import appService from "../../../services/appService";

export default {
    name: "MenuComponent",
    computed: {
        settingMenus: function () {
            return this.$store.getters['settingMenu/lists'];
        }
    },
    mounted() {
        this.$store.dispatch('settingMenu/lists').catch((err) => {
            console.log(err);
        });
    },
    methods: {
        openSettingMenu: function (event) {
            return appService.openSettingMenu(event);
        },
    }
};
</script>