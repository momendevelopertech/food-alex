<template>
    <LoadingComponent :props="loading" />

    <div id="company" class="db-tab-div active">
        <!-- LOGOS -->
        <div class="db-card mb-6">
            <div class="db-card-header">
                <h3 class="db-card-title">{{ $t("menu.theme") }}</h3>
            </div>
            <div class="db-card-body">
                <form @submit.prevent="save">
                    <div class="form-row">
                        <div class="form-col-12 sm:form-col-6">
                            <label for="theme_logo" class="db-field-title">
                                {{ $t("label.logo") }} (128px,43px)
                            </label>
                            <input @change="changeLogo" v-bind:class="errors.theme_logo ? 'invalid' : ''" id="theme_logo"
                                type="file" class="db-field-control" ref="themeLogoProperty"
                                accept="image/png, image/jpeg, image/jpg" />
                            <small class="db-field-alert" v-if="errors.theme_logo">{{
                                errors.theme_logo[0]
                            }}</small>
                            <img class="w-[150px] h-[120px] object-fill rounded-lg mt-2" alt="logo" v-if="theme_logo_reader"
                                :src="theme_logo_reader" />
                        </div>

                        <div class="form-col-12 sm:form-col-6">
                            <label for="fav_icon" class="db-field-title">
                                {{ $t("label.fav_icon") }} (120px,120px)
                            </label>
                            <input @change="changeFavIcon" v-bind:class="errors.theme_favicon_logo ? 'invalid' : ''"
                                id="fav_icon" type="file" class="db-field-control" ref="themeFaviconLogoProperty"
                                accept="image/png, image/jpeg, image/jpg" />
                            <small class="db-field-alert" v-if="errors.theme_favicon_logo">{{
                                errors.theme_favicon_logo[0]
                            }}</small>

                            <img class="w-[120px] h-[120px] object-fill rounded-lg mt-2" alt="logo"
                                v-if="theme_favicon_logo_reader" :src="theme_favicon_logo_reader" />
                        </div>
                        <div class="form-col-12 sm:form-col-6">
                            <label for="footer_logo" class="db-field-title">
                                {{ $t("label.footer_logo") }} (144px,48px)
                            </label>
                            <input @change="changeFooterLogo" v-bind:class="errors.theme_footer_logo ? 'invalid' : ''"
                                id="fav_icon" type="file" class="db-field-control" ref="themeFooterLogoProperty"
                                accept="image/png, image/jpeg, image/jpg" />
                            <small class="db-field-alert" v-if="errors.theme_footer_logo">{{
                                errors.theme_footer_logo[0]
                            }}</small>

                            <img class="w-[150px] h-[120px] object-fill rounded-lg mt-2" alt="logo"
                                v-if="theme_footer_logo_reader" :src="theme_footer_logo_reader" />
                        </div>

                        <div class="form-col-12">
                            <button type="submit" class="db-btn text-white bg-primary">
                                <i class="lab lab-save"></i>
                                <span>{{ $t("button.save") }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- PRIMARY COLOR -->
        <div class="db-card">
            <div class="db-card-header">
                <h3 class="db-card-title">{{ $t("label.primary_color") }}</h3>
            </div>
            <div class="db-card-body">
                <form @submit.prevent="save">
                    <div class="form-row">
                        <div class="form-col-12">
                            <div class="flex items-center gap-3 p-2.5 rounded-lg border border-[#D9DBE9] w-full max-w-[420px]">
                                <!-- Clean filled swatch; the native picker is hidden behind it -->
                                <label
                                    class="relative w-11 h-11 flex-shrink-0 rounded-lg overflow-hidden cursor-pointer ring-1 ring-inset ring-black/10 shadow-sm">
                                    <span class="block w-full h-full" :style="{ backgroundColor: theme_primary_color }"></span>
                                    <input type="color" v-model="theme_primary_color"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                </label>

                                <input type="text" v-model="theme_primary_color"
                                    v-bind:class="errors.theme_primary_color ? 'invalid' : ''"
                                    class="flex-grow uppercase tracking-wide font-rubik text-sm text-heading bg-transparent focus:outline-none"
                                    placeholder="#FF006B" maxlength="7" />
                            </div>
                            <small class="db-field-alert" v-if="errors.theme_primary_color">{{
                                errors.theme_primary_color[0]
                            }}</small>
                        </div>

                        <!-- Presets -->
                        <div class="form-col-12">
                            <label class="db-field-title">{{ $t("label.presets") }}</label>
                            <div class="flex items-center flex-wrap gap-2">
                                <button v-for="preset in colorPresets" :key="preset" type="button"
                                    @click="theme_primary_color = preset" :title="preset"
                                    class="w-7 h-7 rounded-full transition hover:scale-110 ring-1 ring-inset ring-black/10"
                                    :class="theme_primary_color.toLowerCase() === preset.toLowerCase() ? 'ring-2 ring-offset-2 ring-heading' : ''"
                                    :style="{ backgroundColor: preset }"></button>
                            </div>
                        </div>

                        <div class="form-col-12">
                            <button type="submit" class="db-btn text-white bg-primary">
                                <i class="lab lab-save"></i>
                                <span>{{ $t("button.save") }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from "../../components/LoadingComponent";
import alertService from "../../../../services/alertService";

export default {
    name: "ThemeComponent",
    components: { LoadingComponent },
    data() {
        return {
            loading: {
                isActive: false,
            },
            theme_logo: "",
            theme_logo_reader: "",
            theme_favicon_logo: "",
            theme_favicon_logo_reader: "",
            theme_footer_logo: "",
            theme_footer_logo_reader: "",
            theme_primary_color: "#FF006B",
            colorPresets: ["#FF006B", "#FF6B00", "#F5A623", "#16A34A", "#0D9488", "#2563EB", "#7C3AED", "#1F1F39"],
            errors: {},
        };
    },
    mounted() {
        this.list();
    },
    methods: {
        changeLogo: function (e) {
            this.theme_logo = e.target.files[0];
        },
        changeFavIcon: function (e) {
            this.theme_favicon_logo = e.target.files[0];
        },
        changeFooterLogo: function (e) {
            this.theme_footer_logo = e.target.files[0];
        },
        hexToChannels: function (hex) {
            let value = (hex || "").replace("#", "");
            if (value.length === 3) {
                value = value.split("").map((c) => c + c).join("");
            }
            if (!/^[0-9A-Fa-f]{6}$/.test(value)) {
                return null;
            }
            const r = parseInt(value.substring(0, 2), 16);
            const g = parseInt(value.substring(2, 4), 16);
            const b = parseInt(value.substring(4, 6), 16);
            return `${r} ${g} ${b}`;
        },
        applyThemeColors: function () {
            const primary = this.hexToChannels(this.theme_primary_color);
            if (primary) {
                document.documentElement.style.setProperty("--primary", primary);
            }
        },
        list: function () {
            this.loading.isActive = true;
            this.$store
                .dispatch("theme/lists")
                .then((res) => {
                    this.theme_logo_reader = res.data.data.theme_logo;
                    this.theme_favicon_logo_reader = res.data.data.theme_favicon_logo;
                    this.theme_footer_logo_reader = res.data.data.theme_footer_logo;
                    if (res.data.data.theme_primary_color) {
                        this.theme_primary_color = res.data.data.theme_primary_color;
                    }
                    this.loading.isActive = false;
                })
                .catch((err) => {
                    this.loading.isActive = false;
                });
        },
        save: function () {
            try {
                const fd = new FormData();
                if (this.theme_logo) {
                    fd.append("theme_logo", this.theme_logo);
                }
                if (this.theme_favicon_logo) {
                    fd.append("theme_favicon_logo", this.theme_favicon_logo);
                }
                if (this.theme_footer_logo) {
                    fd.append("theme_footer_logo", this.theme_footer_logo);
                }
                fd.append("theme_primary_color", this.theme_primary_color);
                this.loading.isActive = true;
                this.$store
                    .dispatch("theme/save", {
                        form: fd,
                    })
                    .then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(1, this.$t("menu.theme"));
                        this.applyThemeColors();
                        this.list();
                        this.theme_logo = "";
                        this.theme_favicon_logo = "";
                        this.theme_footer_logo = "";
                        this.errors = {};
                        this.$refs.themeLogoProperty.value = null;
                        this.$refs.themeFaviconLogoProperty.value = null;
                        this.$refs.themeFooterLogoProperty.value = null;
                    })
                    .catch((err) => {
                        this.loading.isActive = false;
                        this.errors = err.response.data.errors;
                    });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err);
            }
        },
    },
};
</script>
